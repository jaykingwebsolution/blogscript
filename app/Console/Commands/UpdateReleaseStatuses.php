<?php

namespace App\Console\Commands;

use App\Models\DistributionRequest;
use App\Services\Distribution\AggregatorService;
use App\Jobs\PollDspStatusJob;
use Illuminate\Console\Command;

class UpdateReleaseStatuses extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'distribution:update-statuses 
                            {--batch-size=50 : Number of releases to process in each batch}
                            {--only-processing : Only update releases with processing status}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update release statuses from aggregators';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Updating release statuses from aggregators...');

        $query = DistributionRequest::whereNotNull('aggregator_release_id')
            ->where('dsp_delivery_status', '!=', 'delivered'); // Don't update delivered releases

        if ($this->option('only-processing')) {
            $query->where('dsp_delivery_status', 'processing');
        }

        $releases = $query->orderBy('updated_at', 'asc')
            ->limit($this->option('batch-size'))
            ->get();

        if ($releases->isEmpty()) {
            $this->info('No releases found that need status updates.');
            return self::SUCCESS;
        }

        $this->info("Found {$releases->count()} releases to update");

        $progressBar = $this->output->createProgressBar($releases->count());
        $updated = 0;
        $errors = 0;

        foreach ($releases as $release) {
            try {
                // Queue status update job instead of processing synchronously
                PollDspStatusJob::dispatch($release);
                $updated++;
                
                $this->info("Queued status update for: {$release->song_title} by {$release->artist_name}");
                
            } catch (\Exception $e) {
                $errors++;
                $this->warn("Failed to queue status update for release {$release->id}: " . $e->getMessage());
            }

            $progressBar->advance();
        }

        $progressBar->finish();
        $this->newLine();

        $this->info("Queued status updates for {$updated} releases");
        
        if ($errors > 0) {
            $this->warn("Failed to queue {$errors} status updates");
        }

        return self::SUCCESS;
    }
}
