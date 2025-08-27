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

class PollDspStatusJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public DistributionRequest $distributionRequest;

    /**
     * The number of times the job may be attempted.
     */
    public int $tries = 3;

    /**
     * The maximum number of seconds the job can run.
     */
    public int $timeout = 60;

    /**
     * Create a new job instance.
     */
    public function __construct(DistributionRequest $distributionRequest)
    {
        $this->distributionRequest = $distributionRequest;
    }

    /**
     * Execute the job.
     */
    public function handle(AggregatorService $aggregatorService): void
    {
        Log::info('Polling DSP status for release', [
            'distribution_request_id' => $this->distributionRequest->id,
            'current_status' => $this->distributionRequest->dsp_delivery_status
        ]);

        try {
            $result = $aggregatorService->updateReleaseStatus($this->distributionRequest);

            if ($result['success']) {
                // Refresh the model to get updated status
                $this->distributionRequest->refresh();

                Log::info('DSP status updated', [
                    'distribution_request_id' => $this->distributionRequest->id,
                    'status' => $this->distributionRequest->dsp_delivery_status
                ]);

                // If status is still processing, schedule another check
                if ($this->distributionRequest->dsp_delivery_status === 'processing') {
                    // Schedule next check in 1 hour
                    static::dispatch($this->distributionRequest)->delay(now()->addHour());
                    
                    Log::info('Scheduled next status check', [
                        'distribution_request_id' => $this->distributionRequest->id,
                        'next_check' => now()->addHour()
                    ]);
                }

                // If delivered, schedule royalty report fetch
                if ($this->distributionRequest->dsp_delivery_status === 'delivered') {
                    // Schedule royalty report fetch for next month (give time for streams)
                    FetchRoyaltyReports::dispatch($this->distributionRequest)->delay(now()->addMonth());
                    
                    Log::info('Scheduled royalty report fetch', [
                        'distribution_request_id' => $this->distributionRequest->id,
                        'fetch_date' => now()->addMonth()
                    ]);
                }

            } else {
                Log::warning('Failed to update DSP status', [
                    'distribution_request_id' => $this->distributionRequest->id,
                    'error' => $result['error']
                ]);
                
                // Don't throw exception for status check failures - just log and continue
            }

        } catch (\Exception $e) {
            Log::error('Job failed to poll DSP status', [
                'distribution_request_id' => $this->distributionRequest->id,
                'error' => $e->getMessage(),
                'attempts' => $this->attempts()
            ]);

            // Don't throw exception to avoid retries for non-critical status checks
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error('PollDspStatusJob job failed permanently', [
            'distribution_request_id' => $this->distributionRequest->id,
            'error' => $exception->getMessage()
        ]);
    }

    /**
     * Calculate the number of seconds to wait before retrying the job.
     */
    public function backoff(): array
    {
        return [300, 900, 1800]; // 5 minutes, 15 minutes, 30 minutes
    }
}
