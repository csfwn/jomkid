<?php

namespace App\Services\Access;

use App\Models\AccessCode;
use App\Models\Payment;
use App\Notifications\LifetimeAccessCodeIssued;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

class AccessCodeIssuer
{
    public function issue(Payment $payment): void
    {
        if (AccessCode::query()->where('payment_id', $payment->id)->exists()) {
            return;
        }

        $plainCode = $this->generateCode();
        AccessCode::create([
            'payment_id' => $payment->id,
            'email' => Str::lower($payment->customer_email),
            'code_hash' => AccessCode::hashCode($plainCode),
            'code_hint' => Str::substr($plainCode, -4),
            'status' => AccessCode::STATUS_ACTIVE,
        ]);

        $email = $payment->customer_email;
        $name = $payment->customer_name;
        $amountSen = $payment->amount_sen;
        $packageName = (string) config('packages.'.$payment->package_code.'.name', 'JomKid');
        DB::afterCommit(function () use ($email, $name, $plainCode, $amountSen, $packageName): void {
            Notification::route('mail', $email)
                ->notify(new LifetimeAccessCodeIssued($plainCode, $name, $amountSen, $packageName));
        });
    }

    private function generateCode(): string
    {
        do {
            $plainCode = 'JOMKID-'.Str::upper(Str::random(4)).'-'.Str::upper(Str::random(4)).'-'.Str::upper(Str::random(4));
        } while (AccessCode::query()->where('code_hash', AccessCode::hashCode($plainCode))->exists());

        return $plainCode;
    }
}
