<?php

namespace App\Jobs;

use App\Models\DistributionPayout;
use App\Services\Distribution\PayoutService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessPayoutJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public DistributionPayout $payout;

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
    public function __construct(DistributionPayout $payout)
    {
        $this->payout = $payout;
    }

    /**
     * Execute the job.
     */
    public function handle(PayoutService $payoutService): void
    {
        Log::info('Processing payout job', [
            'payout_id' => $this->payout->id,
            'user_id' => $this->payout->user_id,
            'amount' => $this->payout->amount,
            'method' => $this->payout->method
        ]);

        try {
            $result = $payoutService->processPayout($this->payout);

            if ($result['success']) {
                Log::info('Payout processed successfully', [
                    'payout_id' => $this->payout->id,
                    'transaction_reference' => $result['transaction_reference'] ?? null
                ]);
            } else {
                Log::error('Payout processing failed', [
                    'payout_id' => $this->payout->id,
                    'error' => $result['error']
                ]);
            }

        } catch (\Exception $e) {
            Log::error('Exception during payout job processing', [
                'payout_id' => $this->payout->id,
                'error' => $e->getMessage(),
                'attempts' => $this->attempts()
            ]);

            throw $e;
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error('ProcessPayoutJob failed permanently', [
            'payout_id' => $this->payout->id,
            'error' => $exception->getMessage(),
            'attempts' => $this->attempts()
        ]);

        $this->payout->update([
            'status' => 'failed',
            'notes' => 'Job failed permanently: ' . $exception->getMessage()
        ]);
    }

    /**
     * Calculate the number of seconds to wait before retrying the job.
     */
    public function backoff(): array
    {
        return [60, 300, 900]; // 1 minute, 5 minutes, 15 minutes
    }
}
