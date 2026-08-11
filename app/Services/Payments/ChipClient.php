<?php

namespace App\Services\Payments;

use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class ChipClient
{
    /** @return array<string, mixed> */
    public function createPurchase(User $user, Payment $payment): array
    {
        $payload = [
            'brand_id' => $this->brandId(),
            'client' => [
                'email' => $user->email,
                'full_name' => $user->name,
            ],
            'purchase' => [
                'currency' => 'MYR',
                'language' => 'ms',
                'products' => [[
                    'name' => 'JomKid Annual Access',
                    'price' => $payment->amount_sen,
                ]],
            ],
            'reference' => $payment->reference,
            'send_receipt' => true,
            'platform' => 'web',
            'success_redirect' => route('checkout.success', $payment->uuid),
            'failure_redirect' => route('checkout.failure', $payment->uuid),
            'cancel_redirect' => route('checkout.failure', $payment->uuid),
            'success_callback' => route('webhooks.chip'),
            'tags' => ['jomkid', 'annual-access'],
        ];

        /** @var array<string, mixed> $response */
        $response = $this->request(retry: false)->post($this->url('/purchases/'), $payload)->throw()->json();

        return $response;
    }

    /** @return array<string, mixed> */
    public function retrievePurchase(string $purchaseId): array
    {
        /** @var array<string, mixed> $response */
        $response = $this->request()->get($this->url("/purchases/{$purchaseId}/"))->throw()->json();

        return $response;
    }

    public function verifySignature(string $rawBody, ?string $signature): bool
    {
        if (! is_string($signature) || $signature === '') {
            return false;
        }

        $decoded = base64_decode($signature, true);
        if ($decoded === false) {
            return false;
        }

        return openssl_verify($rawBody, $decoded, $this->publicKey(), OPENSSL_ALGO_SHA256) === 1;
    }

    public function publicKey(): string
    {
        $configured = config('services.chip.public_key');
        if (is_string($configured) && $configured !== '') {
            return str_replace('\\n', "\n", $configured);
        }

        $cacheKey = 'chip.collect.public-key.'.hash('sha256', $this->baseUrl());

        return Cache::remember($cacheKey, now()->addHours(12), function (): string {
            $response = $this->request()->get($this->url('/public_key/'))->throw();
            $data = $response->json();
            $key = is_string($data) ? $data : Arr::get(is_array($data) ? $data : [], 'public_key');

            if (! is_string($key) || $key === '') {
                $key = trim($response->body(), "\"\n\r ");
            }

            if (! str_contains($key, 'BEGIN PUBLIC KEY')) {
                throw new RuntimeException('CHIP returned an invalid webhook public key.');
            }

            return str_replace('\\n', "\n", $key);
        });
    }

    private function request(bool $retry = true): PendingRequest
    {
        $secret = config('services.chip.secret_key');
        if (! is_string($secret) || $secret === '') {
            throw new RuntimeException('CHIP_SECRET_KEY is not configured.');
        }

        $request = Http::acceptJson()
            ->asJson()
            ->withToken($secret)
            ->timeout((int) config('services.chip.timeout', 15));

        return $retry ? $request->retry(2, 200) : $request;
    }

    private function brandId(): string
    {
        $brandId = config('services.chip.brand_id');
        if (! is_string($brandId) || $brandId === '') {
            throw new RuntimeException('CHIP_BRAND_ID is not configured.');
        }

        return $brandId;
    }

    private function baseUrl(): string
    {
        return rtrim((string) config('services.chip.base_url', 'https://gate.chip-in.asia/api/v1'), '/');
    }

    private function url(string $path): string
    {
        return $this->baseUrl().'/'.ltrim($path, '/');
    }
}
