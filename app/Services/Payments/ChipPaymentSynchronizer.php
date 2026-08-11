<?php

namespace App\Services\Payments;

use App\Models\AffiliateCommission;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class ChipPaymentSynchronizer
{
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

                if (! in_array($locked->status, [Payment::STATUS_PAID, Payment::STATUS_REFUNDED], true)) {
                    $paidAt = now();
                    $locked->status = Payment::STATUS_PAID;
                    $locked->paid_at = $paidAt;
                    $locked->failed_at = null;
                    $locked->subscription?->update([
                        'status' => 'active',
                        'starts_at' => $paidAt,
                        'ends_at' => $paidAt->copy()->addYear(),
                    ]);

                    if ($locked->affiliate_user_id && $locked->subscription_id) {
                        AffiliateCommission::firstOrCreate(
                            ['subscription_id' => $locked->subscription_id],
                            [
                                'affiliate_user_id' => $locked->affiliate_user_id,
                                'buyer_user_id' => $locked->user_id,
                                'amount_sen' => (int) config('affiliate.commission_sen', 3450),
                                'status' => 'pending',
                                'available_at' => $paidAt->copy()->addDays(
                                    (int) config('affiliate.refund_window_days', 30),
                                ),
                            ],
                        );
                    }
                }
            } elseif (in_array($status, ['refunded', 'chargeback'], true)) {
                $this->applyReversal($locked);
            } elseif (in_array($status, ['error', 'cancelled', 'expired', 'blocked', 'released'], true)) {
                if ($locked->status !== Payment::STATUS_PAID) {
                    $locked->status = $status === 'cancelled'
                        ? Payment::STATUS_CANCELLED
                        : Payment::STATUS_FAILED;
                    $locked->failed_at = now();
                    $locked->subscription?->update([
                        'status' => $status === 'cancelled' ? 'cancelled' : 'failed',
                    ]);
                }
            } elseif ($locked->status === Payment::STATUS_INITIALIZED) {
                $locked->status = Payment::STATUS_CREATED;
            }

            $locked->save();

            return $locked->refresh();
        });
    }

    /** @param array<string, mixed> $event */
    public function reverse(Payment $payment, array $event): Payment
    {
        $amount = (int) data_get($event, 'payment.amount');
        $currency = data_get($event, 'payment.currency');
        $reference = data_get($event, 'reference');

        if ($amount < 1 || $amount > $payment->amount_sen || $currency !== $payment->currency) {
            throw new RuntimeException('CHIP reversal amount or currency does not match the local payment.');
        }

        if (is_string($reference) && $reference !== '' && $reference !== $payment->reference) {
            throw new RuntimeException('CHIP reversal reference does not match the local payment.');
        }

        return DB::transaction(function () use ($payment, $event): Payment {
            $locked = Payment::query()->whereKey($payment->id)->lockForUpdate()->firstOrFail();
            $locked->setAttribute('provider_payload', $event);
            $this->applyReversal($locked);
            $locked->save();

            return $locked->refresh();
        });
    }

    private function applyReversal(Payment $payment): void
    {
        if ($payment->status === Payment::STATUS_REFUNDED) {
            return;
        }

        $payment->status = Payment::STATUS_REFUNDED;
        $payment->refunded_at = now();
        $payment->subscription?->update([
            'status' => 'cancelled',
            'ends_at' => now(),
        ]);
        $payment->subscription?->commissions()->update([
            'status' => 'reversed',
            'available_at' => null,
        ]);
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
