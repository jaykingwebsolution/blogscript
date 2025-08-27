<?php

namespace App\Console\Commands;

use App\Services\Distribution\PayoutService;
use Illuminate\Console\Command;

class ProcessAutomaticPayouts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'distribution:process-payouts 
                            {--dry-run : Run without actually processing payouts}
                            {--threshold= : Override minimum payout threshold}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process automatic payouts for eligible users';

    /**
     * Execute the console command.
     */
    public function handle(PayoutService $payoutService): int
    {
        $this->info('Starting automatic payout processing...');

        if ($this->option('dry-run')) {
            $this->warn('Running in DRY-RUN mode - no actual payouts will be processed');
        }

        try {
            if ($this->option('dry-run')) {
                // In dry-run mode, just show eligible users
                $this->showEligibleUsers($payoutService);
            } else {
                $processed = $payoutService->processAutomaticPayouts();
                $this->info("Successfully processed {$processed} automatic payouts");
            }

            return self::SUCCESS;

        } catch (\Exception $e) {
            $this->error('Failed to process automatic payouts: ' . $e->getMessage());
            return self::FAILURE;
        }
    }

    /**
     * Show users eligible for automatic payouts (dry-run mode)
     */
    protected function showEligibleUsers(PayoutService $payoutService): void
    {
        $threshold = $this->option('threshold') ?: config('services.distribution.auto_payout_threshold', 100.00);
        $this->info("Checking for users with balance >= \${$threshold}");

        // This would need to be implemented in PayoutService
        // For now, just show the threshold
        $this->table(
            ['Setting', 'Value'],
            [
                ['Minimum Threshold', '$' . number_format($threshold, 2)],
                ['Mode', 'Dry Run'],
            ]
        );
    }
}
