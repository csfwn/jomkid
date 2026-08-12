<?php

namespace App\Services\Payments;

use App\Models\AffiliateCommission;
use App\Models\Payment;
use App\Services\Access\AccessCodeIssuer;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class ChipPaymentSynchronizer
{
    public function __construct(private readonly AccessCodeIssuer $accessCodes) {}

    /** @param array<string, mixed> $purchase */
    public function sync(Payment $payment, array $purchase): Payment
    {
        $purchaseId = data_get($purchase, 'id');
        if (! is_string($purchaseId) || $purchaseId !== $payment->provider_purchase_id) {
            throw new RuntimeException('CHIP purchase ID does not match the local payment.');
        }

        $status = data_get($purchase, 'status');
        if (! is_string($status) || $status === '') {
            throw new RuntimeException('CHIP purchase payload has no status.');
        }

        return DB::transaction(function () use ($payment, $purchase, $status): Payment {
            $locked = Payment::query()->whereKey($payment->id)->lockForUpdate()->firstOrFail();
            $locked->setAttribute('provider_payload', $purchase);

            if ($status === 'paid') {
                $this->assertPaidAmount($locked, $purchase);

                if ($locked->status !== Payment::STATUS_PAID) {
                    $paidAt = now();
                    $locked->status = Payment::STATUS_PAID;
                    $locked->paid_at = $paidAt;
                    $locked->failed_at = null;
                    $this->accessCodes->issue($locked);

                    if ($locked->affiliate_user_id) {
                        AffiliateCommission::firstOrCreate(
                            ['payment_id' => $locked->id],
                            [
                                'affiliate_user_id' => $locked->affiliate_user_id,
                                'buyer_user_id' => null,

                                'amount_sen' => intdiv(
                                    $locked->amount_sen * (int) config('affiliate.commission_percent', 50),
                                    100,
                                ),
                                'status' => 'pending',
                                'available_at' => $paidAt,
                            ],
                        );
                    }
                }
            } elseif (in_array($status, ['error', 'cancelled', 'expired', 'blocked', 'released'], true)) {
                if ($locked->status !== Payment::STATUS_PAID) {
                    $locked->status = $status === 'cancelled'
                        ? Payment::STATUS_CANCELLED
                        : Payment::STATUS_FAILED;
                    $locked->failed_at = now();

                }
            } elseif ($locked->status === Payment::STATUS_INITIALIZED) {
                $locked->status = Payment::STATUS_CREATED;
            }

            $locked->save();

            return $locked->refresh();
        });
    }

    /** @param array<string, mixed> $purchase */
    private function assertPaidAmount(Payment $payment, array $purchase): void
    {
        $amount = data_get($purchase, 'purchase.total');
        $currency = data_get($purchase, 'purchase.currency');
        $reference = data_get($purchase, 'reference');

        if ((int) $amount !== $payment->amount_sen || $currency !== $payment->currency) {
            throw new RuntimeException('CHIP paid amount or currency does not match the local payment.');
        }

        if (is_string($reference) && $reference !== '' && $reference !== $payment->reference) {
            throw new RuntimeException('CHIP reference does not match the local payment.');
        }
    }
}
