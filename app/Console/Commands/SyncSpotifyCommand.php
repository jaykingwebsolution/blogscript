<?php

namespace App\Console\Commands;

use App\Jobs\SyncSpotifyArtists;
use App\Models\SpotifyArtist;
use Illuminate\Console\Command;

class SyncSpotifyCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'spotify:sync 
                            {--artists=* : Specific artist IDs to sync}
                            {--all : Sync all artists}
                            {--queue : Run sync via queue instead of synchronously}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync Spotify artists data and check for new releases';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $artistIds = $this->option('artists');
        $syncAll = $this->option('all');
        $useQueue = $this->option('queue');

        if ($artistIds && $syncAll) {
            $this->error('Cannot specify both --artists and --all options');
            return 1;
        }

        // Validate artist IDs if provided
        if ($artistIds) {
            $existingIds = SpotifyArtist::whereIn('id', $artistIds)->pluck('id')->toArray();
            $invalidIds = array_diff($artistIds, $existingIds);
            
            if (!empty($invalidIds)) {
                $this->error('Invalid artist IDs: ' . implode(', ', $invalidIds));
                return 1;
            }
        }

        // Show what will be synced
        if ($artistIds) {
            $count = count($artistIds);
            $this->info("Syncing {$count} specific artist(s)...");
        } elseif ($syncAll) {
            $count = SpotifyArtist::active()->count();
            $this->info("Syncing all {$count} active artists...");
        } else {
            $count = SpotifyArtist::needsSync(48)->active()->count();
            $this->info("Syncing {$count} artists that need updates (not synced in 48 hours)...");
        }

        if ($count === 0) {
            $this->info('No artists to sync.');
            return 0;
        }

        // Confirm before proceeding if syncing many artists
        if ($count > 10 && !$this->confirm('This will sync ' . $count . ' artists. Continue?')) {
            $this->info('Sync cancelled.');
            return 0;
        }

        // Dispatch job or run synchronously
        if ($useQueue) {
            SyncSpotifyArtists::dispatch($artistIds, $syncAll);
            $this->info('Sync job queued successfully. Check the queue worker logs for progress.');
        } else {
            // Run synchronously
            $job = new SyncSpotifyArtists($artistIds, $syncAll);
            $spotifyService = app(\App\Services\SpotifyService::class);
            
            $this->info('Starting synchronous sync...');
            $progressBar = $this->output->createProgressBar($count);
            $progressBar->start();
            
            try {
                // We'll manually handle progress since we can't easily hook into the job
                $job->handle($spotifyService);
                $progressBar->finish();
                $this->newLine();
                $this->info('Sync completed successfully!');
            } catch (\Exception $e) {
                $progressBar->finish();
                $this->newLine();
                $this->error('Sync failed: ' . $e->getMessage());
                return 1;
            }
        }

        return 0;
    }
}
