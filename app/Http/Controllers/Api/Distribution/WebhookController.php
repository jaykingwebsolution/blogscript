<?php

namespace App\Http\Controllers\Api\Distribution;

use App\Http\Controllers\Controller;
use App\Models\DistributionRequest;
use App\Models\DistributionEarning;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class WebhookController extends Controller
{
    /**
     * Handle delivery status updates from aggregators
     */
    public function deliveryStatus(Request $request): JsonResponse
    {
        try {
            // Verify webhook signature
            if (!$this->verifyWebhookSignature($request)) {
                Log::warning('Invalid webhook signature', [
                    'ip' => $request->ip(),
                    'headers' => $request->headers->all()
                ]);
                return response()->json(['error' => 'Invalid signature'], 403);
            }

            $payload = $request->all();
            Log::info('Received delivery status webhook', [
                'payload' => $payload,
                'source_ip' => $request->ip()
            ]);

            // Find the distribution request
            $distributionRequest = $this->findDistributionRequest($payload);
            if (!$distributionRequest) {
                Log::warning('Distribution request not found for webhook', ['payload' => $payload]);
                return response()->json(['error' => 'Distribution request not found'], 404);
            }

            // Process the status update
            $this->processDeliveryStatusUpdate($distributionRequest, $payload);

            return response()->json([
                'message' => 'Status update processed successfully',
                'distribution_request_id' => $distributionRequest->id
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to process delivery status webhook', [
                'error' => $e->getMessage(),
                'payload' => $request->all()
            ]);

            return response()->json(['error' => 'Failed to process webhook'], 500);
        }
    }

    /**
     * Handle royalty data from aggregators
     */
    public function royalties(Request $request): JsonResponse
    {
        try {
            // Verify webhook signature
            if (!$this->verifyWebhookSignature($request)) {
                Log::warning('Invalid royalty webhook signature', [
                    'ip' => $request->ip(),
                    'headers' => $request->headers->all()
                ]);
                return response()->json(['error' => 'Invalid signature'], 403);
            }

            $payload = $request->all();
            Log::info('Received royalty webhook', [
                'payload_keys' => array_keys($payload),
                'source_ip' => $request->ip()
            ]);

            // Process royalty data
            $processed = $this->processRoyaltyData($payload);

            return response()->json([
                'message' => 'Royalty data processed successfully',
                'processed_records' => $processed
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to process royalty webhook', [
                'error' => $e->getMessage(),
                'payload' => $request->all()
            ]);

            return response()->json(['error' => 'Failed to process webhook'], 500);
        }
    }

    /**
     * Verify webhook signature
     */
    protected function verifyWebhookSignature(Request $request): bool
    {
        $signature = $request->header('X-Webhook-Signature') ?? $request->header('X-Signature');
        
        if (!$signature) {
            return false;
        }

        // Get the webhook secret from configuration
        $webhookSecret = config('services.distribution.webhook_secret', env('DISTRIBUTION_WEBHOOK_SECRET'));
        
        if (!$webhookSecret) {
            Log::warning('Webhook secret not configured');
            return false;
        }

        $payload = $request->getContent();
        $computedHash = hash_hmac('sha256', $payload, $webhookSecret);

        // Accept signatures with or without 'sha256=' prefix
        $normalizedSignature = $signature;
        if (Str::startsWith($normalizedSignature, 'sha256=')) {
            $normalizedSignature = substr($normalizedSignature, strlen('sha256='));
        }

        return hash_equals($computedHash, $normalizedSignature);
    }

    /**
     * Find distribution request from webhook payload
     */
    protected function findDistributionRequest(array $payload): ?DistributionRequest
    {
        // Try different possible fields for the aggregator release ID
        $releaseId = $payload['release_id'] 
                  ?? $payload['aggregator_release_id'] 
                  ?? $payload['id'] 
                  ?? null;

        if (!$releaseId) {
            return null;
        }

        return DistributionRequest::where('aggregator_release_id', $releaseId)->first();
    }

    /**
     * Process delivery status update
     */
    protected function processDeliveryStatusUpdate(DistributionRequest $request, array $payload): void
    {
        $oldStatus = $request->dsp_delivery_status;
        
        // Map aggregator status to our local status
        $newStatus = $this->mapStatusFromWebhook($payload);
        
        if ($newStatus && $newStatus !== $oldStatus) {
            $request->update([
                'dsp_delivery_status' => $newStatus,
                'aggregator_response' => array_merge(
                    $request->aggregator_response ?? [],
                    ['last_webhook' => $payload]
                )
            ]);

            Log::info('Updated distribution status from webhook', [
                'distribution_request_id' => $request->id,
                'old_status' => $oldStatus,
                'new_status' => $newStatus
            ]);

            // If status changed to delivered, update delivered_at timestamp
            if ($newStatus === 'delivered' && !$request->delivered_at) {
                $request->update(['delivered_at' => now()]);
            }
        }
    }

    /**
     * Map webhook status to local status
     */
    protected function mapStatusFromWebhook(array $payload): ?string
    {
        $status = $payload['status'] ?? $payload['delivery_status'] ?? null;
        
        if (!$status) {
            return null;
        }

        $statusMap = [
            'submitted' => 'processing',
            'processing' => 'processing',
            'pending' => 'processing',
            'approved' => 'processing',
            'delivered' => 'delivered',
            'live' => 'delivered',
            'published' => 'delivered',
            'active' => 'delivered',
            'rejected' => 'failed',
            'failed' => 'failed',
            'error' => 'failed',
        ];

        return $statusMap[strtolower($status)] ?? null;
    }

    /**
     * Process royalty data from webhook
     */
    protected function processRoyaltyData(array $payload): int
    {
        $processed = 0;
        $reports = $payload['reports'] ?? $payload['royalties'] ?? $payload['earnings'] ?? [];

        if (empty($reports)) {
            Log::warning('No royalty reports in webhook payload');
            return 0;
        }

        foreach ($reports as $report) {
            $distributionRequest = $this->findDistributionRequestForRoyalty($report);
            
            if (!$distributionRequest) {
                Log::warning('Could not find distribution request for royalty report', [
                    'report' => $report
                ]);
                continue;
            }

            $this->createOrUpdateEarning($distributionRequest, $report);
            $processed++;
        }

        return $processed;
    }

    /**
     * Find distribution request for royalty report
     */
    protected function findDistributionRequestForRoyalty(array $report): ?DistributionRequest
    {
        $releaseId = $report['release_id'] ?? $report['aggregator_release_id'] ?? null;
        
        if ($releaseId) {
            return DistributionRequest::where('aggregator_release_id', $releaseId)->first();
        }

        // Try to match by ISRC if release ID not available
        $isrc = $report['isrc'] ?? null;
        if ($isrc) {
            return DistributionRequest::where('isrc', $isrc)->first();
        }

        return null;
    }

    /**
     * Create or update earning record
     */
    protected function createOrUpdateEarning(DistributionRequest $request, array $report): void
    {
        $platform = $report['platform'] ?? $report['dsp'] ?? 'unknown';
        $territory = $report['territory'] ?? $report['country'] ?? null;
        $periodStart = $report['period_start'] ?? $report['from_date'] ?? null;
        $periodEnd = $report['period_end'] ?? $report['to_date'] ?? null;

        $existingEarning = DistributionEarning::where([
            'distribution_request_id' => $request->id,
            'platform' => $platform,
            'territory' => $territory,
            'period_start' => $periodStart,
            'period_end' => $periodEnd,
        ])->first();

        $earningData = [
            'distribution_request_id' => $request->id,
            'user_id' => $request->user_id,
            'platform' => $platform,
            'territory' => $territory,
            'amount' => (float) ($report['amount'] ?? $report['revenue'] ?? 0),
            'currency' => $report['currency'] ?? 'USD',
            'streams' => (int) ($report['streams'] ?? 0),
            'downloads' => (int) ($report['downloads'] ?? 0),
            'period_start' => $periodStart,
            'period_end' => $periodEnd,
            'status' => 'confirmed'
        ];

        if ($existingEarning) {
            $existingEarning->update($earningData);
            Log::info('Updated existing earning from webhook', [
                'earning_id' => $existingEarning->id,
                'amount' => $earningData['amount']
            ]);
        } else {
            DistributionEarning::create($earningData);
            Log::info('Created new earning from webhook', [
                'distribution_request_id' => $request->id,
                'platform' => $platform,
                'amount' => $earningData['amount']
            ]);
        }
    }
}