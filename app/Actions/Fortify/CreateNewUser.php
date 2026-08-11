<?php

namespace App\Actions\Fortify;

use App\Concerns\PasswordValidationRules;
use App\Concerns\ProfileValidationRules;
use App\Models\AccessCode;
use App\Models\AffiliateCommission;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules, ProfileValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            ...$this->profileRules(),
            'access_code' => ['required', 'string', 'max:64'],
            'password' => $this->passwordRules(),
        ], [
            'access_code.required' => 'Kod akses daripada e-mel pembelian diperlukan.',
        ])->validate();

        return DB::transaction(function () use ($input): User {
            $accessCode = AccessCode::query()
                ->with('payment')
                ->where('code_hash', AccessCode::hashCode($input['access_code']))
                ->lockForUpdate()
                ->first();

            if (! $accessCode || $accessCode->status !== AccessCode::STATUS_ACTIVE) {
                throw ValidationException::withMessages([
                    'access_code' => 'Kod akses tidak sah atau telah digunakan.',
                ]);
            }

            if (Str::lower($input['email']) !== Str::lower($accessCode->email)) {
                throw ValidationException::withMessages([
                    'email' => 'Gunakan alamat e-mel yang menerima kod akses ini.',
                ]);
            }

            if ($accessCode->payment?->status !== Payment::STATUS_PAID) {
                throw ValidationException::withMessages([
                    'access_code' => 'Pembayaran untuk kod akses ini belum disahkan.',
                ]);
            }

            $user = User::create([
                'name' => $input['name'],
                'email' => Str::lower($input['email']),
                'password' => $input['password'],
                'access_status' => 'active',
                'lifetime_access_at' => now(),
            ]);

            $accessCode->update([
                'status' => AccessCode::STATUS_USED,
                'used_by_user_id' => $user->id,
                'used_at' => now(),
            ]);
            $accessCode->payment->update(['user_id' => $user->id]);
            AffiliateCommission::query()
                ->where('payment_id', $accessCode->payment_id)
                ->update(['buyer_user_id' => $user->id]);

            return $user;
        });
    }
}
