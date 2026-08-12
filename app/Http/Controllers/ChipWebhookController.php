<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Services\Payments\ChipClient;
use App\Services\Payments\ChipPaymentSynchronizer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use JsonException;
use RuntimeException;

class ChipWebhookController extends Controller
{
    public function __invoke(
        Request $request,
        ChipClient $chip,
        ChipPaymentSynchronizer $synchronizer,
    ): JsonResponse {
        $rawBody = $request->getContent();

        if (! $chip->verifySignature($rawBody, $request->header('X-Signature'))) {
            return response()->json(['message' => 'Invalid signature.'], 401);
        }

        try {
            /** @var array<string, mixed> $payload */
            $payload = json_decode($rawBody, true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException) {
            return response()->json(['message' => 'Invalid JSON.'], 400);
        }

        $eventType = data_get($payload, 'event_type');
        if (in_array($eventType, ['payment.refunded', 'payment.charged_back'], true)) {
            return response()->json(['received' => true]);
        }

        $purchaseId = data_get($payload, 'id');
        if (! is_string($purchaseId) || $purchaseId === '') {
            throw new RuntimeException('Verified CHIP callback has no purchase ID.');
        }

        $payment = Payment::query()->where('provider_purchase_id', $purchaseId)->first();
        if (! $payment) {
            return response()->json(['received' => true]);
        }

        $synchronizer->sync($payment, $payload);

        return response()->json(['received' => true]);
    }
}
