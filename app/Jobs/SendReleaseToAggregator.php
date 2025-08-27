<?php

namespace App\Jobs;

use App\Models\DistributionRequest;
use App\Services\Distribution\AggregatorService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendReleaseToAggregator implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public DistributionRequest $distributionRequest;
    public ?string $preferredProvider;

    /**
     * The number of times the job may be attempted.
     */
    public int $tries = 3;

    /**
     * The maximum number of seconds the job can run.
     */
    public int $timeout = 120;

    /**
     * Create a new job instance.
     */
    public function __construct(DistributionRequest $distributionRequest, ?string $preferredProvider = null)
    {
        $this->distributionRequest = $distributionRequest;
        $this->preferredProvider = $preferredProvider;
    }

    /**
     * Execute the job.
     */
    public function handle(AggregatorService $aggregatorService): void
    {
        Log::info('Starting release submission to aggregator', [
            'distribution_request_id' => $this->distributionRequest->id,
            'artist_name' => $this->distributionRequest->artist_name,
            'song_title' => $this->distributionRequest->song_title,
            'preferred_provider' => $this->preferredProvider
        ]);

        try {
            $result = $aggregatorService->sendRelease($this->distributionRequest, $this->preferredProvider);

            if ($result['success']) {
                Log::info('Release successfully sent to aggregator', [
                    'distribution_request_id' => $this->distributionRequest->id,
                    'aggregator_release_id' => $result['aggregator_release_id'],
                    'provider' => $this->distributionRequest->aggregator_provider
                ]);

                // Optionally send notification to user here
                // event(new ReleaseSubmittedToAggregator($this->distributionRequest));

            } else {
                Log::error('Failed to send release to aggregator', [
                    'distribution_request_id' => $this->distributionRequest->id,
                    'error' => $result['error']
                ]);

                // If this was the last attempt, mark as failed
                if ($this->attempts() >= $this->tries) {
                    $this->distributionRequest->update([
                        'dsp_delivery_status' => 'failed',
                        'notes' => 'Failed to submit to aggregator: ' . $result['error']
                    ]);
                }

                throw new \Exception('Aggregator submission failed: ' . $result['error']);
            }

        } catch (\Exception $e) {
            Log::error('Job failed to send release to aggregator', [
                'distribution_request_id' => $this->distributionRequest->id,
                'error' => $e->getMessage(),
                'attempts' => $this->attempts()
            ]);

            // If this was the last attempt, mark as failed
            if ($this->attempts() >= $this->tries) {
                $this->distributionRequest->update([
                    'dsp_delivery_status' => 'failed',
                    'notes' => 'Failed to submit to aggregator after ' . $this->tries . ' attempts: ' . $e->getMessage()
                ]);
            }

            throw $e;
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error('SendReleaseToAggregator job failed permanently', [
            'distribution_request_id' => $this->distributionRequest->id,
            'error' => $exception->getMessage(),
            'attempts' => $this->attempts()
        ]);

        $this->distributionRequest->update([
            'dsp_delivery_status' => 'failed',
            'notes' => 'Permanent failure: ' . $exception->getMessage()
        ]);
    }

    /**
     * Calculate the number of seconds to wait before retrying the job.
     */
    public function backoff(): array
    {
        return [30, 300, 900]; // 30 seconds, 5 minutes, 15 minutes
    }
}
