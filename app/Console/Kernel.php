<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Sync Spotify artists daily at 2 AM
        $schedule->command('spotify:sync --queue')
                 ->daily()
                 ->at('02:00')
                 ->description('Sync Spotify artists for new releases');
        
        // Also sync on Sunday at 6 AM (weekly full sync)
        $schedule->command('spotify:sync --all --queue')
                 ->weekly()
                 ->sundays()
                 ->at('06:00')
                 ->description('Weekly full sync of all Spotify artists');

        // Distribution system scheduled tasks
        
        // Update release statuses every 2 hours during business hours
        $schedule->command('distribution:update-statuses --only-processing')
                 ->hourlyAt([0, 15, 30, 45]) // Every 15 minutes
                 ->between('08:00', '20:00')
                 ->description('Update processing release statuses from aggregators');

        // Process automatic payouts daily at 10 AM
        $schedule->command('distribution:process-payouts')
                 ->daily()
                 ->at('10:00')
                 ->description('Process automatic payouts for eligible users');

        // Update all release statuses (including delivered) weekly
        $schedule->command('distribution:update-statuses --batch-size=100')
                 ->weekly()
                 ->mondays()
                 ->at('03:00')
                 ->description('Weekly status update for all releases');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}