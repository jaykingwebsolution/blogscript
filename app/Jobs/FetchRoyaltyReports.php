<?php

namespace App\Jobs;

use App\Models\DistributionRequest;
use App\Models\DistributionEarning;
use App\Services\Distribution\AggregatorService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class FetchRoyaltyReports implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public DistributionRequest $distributionRequest;
    public array $dateRange;

    /**
     * The number of times the job may be attempted.
     */
    public int $tries = 3;

    /**
     * The maximum number of seconds the job can run.
     */
    public int $timeout = 300;

    /**
     * Create a new job instance.
     */
    public function __construct(DistributionRequest $distributionRequest, array $dateRange = [])
    {
        $this->distributionRequest = $distributionRequest;
        $this->dateRange = $dateRange ?: [
            'from' => Carbon::now()->subMonth()->format('Y-m-d'),
            'to' => Carbon::now()->format('Y-m-d')
        ];
    }

    /**
     * Execute the job.
     */
    public function handle(AggregatorService $aggregatorService): void
    {
        Log::info('Fetching royalty reports', [
            'distribution_request_id' => $this->distributionRequest->id,
            'date_range' => $this->dateRange
        ]);

        try {
            $result = $aggregatorService->fetchRoyaltyReports($this->distributionRequest, $this->dateRange);

            if ($result['success']) {
                $this->processRoyaltyReports($result['reports']);
                
                Log::info('Royalty reports processed successfully', [
                    'distribution_request_id' => $this->distributionRequest->id,
                    'reports_count' => count($result['reports'])
                ]);
            } else {
                Log::error('Failed to fetch royalty reports', [
                    'distribution_request_id' => $this->distributionRequest->id,
                    'error' => $result['error']
                ]);
                
                throw new \Exception('Failed to fetch royalty reports: ' . $result['error']);
            }

        } catch (\Exception $e) {
            Log::error('Job failed to fetch royalty reports', [
                'distribution_request_id' => $this->distributionRequest->id,
                'error' => $e->getMessage(),
                'attempts' => $this->attempts()
            ]);

            throw $e;
        }
    }

    /**
     * Process and save royalty reports
     */
    protected function processRoyaltyReports(array $reports): void
    {
        foreach ($reports as $report) {
            $existingEarning = DistributionEarning::where([
                'distribution_request_id' => $this->distributionRequest->id,
                'platform' => $report['platform'],
                'territory' => $report['territory'],
                'period_start' => $report['period_start'],
                'period_end' => $report['period_end']
            ])->first();

            if (!$existingEarning) {
                DistributionEarning::create([
                    'distribution_request_id' => $this->distributionRequest->id,
                    'user_id' => $this->distributionRequest->user_id,
                    'platform' => $report['platform'],
                    'territory' => $report['territory'],
                    'amount' => $report['amount'],
                    'currency' => $report['currency'],
                    'streams' => $report['streams'],
                    'downloads' => $report['downloads'],
                    'period_start' => $report['period_start'],
                    'period_end' => $report['period_end'],
                    'status' => 'confirmed'
                ]);

                Log::info('Created new earnings record', [
                    'distribution_request_id' => $this->distributionRequest->id,
                    'platform' => $report['platform'],
                    'amount' => $report['amount'],
                    'streams' => $report['streams']
                ]);
            } else {
                // Update existing record if amounts have changed
                if ($existingEarning->amount != $report['amount'] || $existingEarning->streams != $report['streams']) {
                    $existingEarning->update([
                        'amount' => $report['amount'],
                        'streams' => $report['streams'],
                        'downloads' => $report['downloads']
                    ]);

                    Log::info('Updated existing earnings record', [
                        'earning_id' => $existingEarning->id,
                        'old_amount' => $existingEarning->getOriginal('amount'),
                        'new_amount' => $report['amount']
                    ]);
                }
            }
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error('FetchRoyaltyReports job failed permanently', [
            'distribution_request_id' => $this->distributionRequest->id,
            'error' => $exception->getMessage(),
            'attempts' => $this->attempts()
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
