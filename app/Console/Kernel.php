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
        $schedule->command('sync:topups');
        $schedule->command('sync:topup_discounts')->everyMinute();
        $schedule->command('process:files')->runInBackground()->withoutOverlapping(30);
        $schedule->command('sync:countries')->daily();
        $schedule->command('sync:operators')->daily();
        $schedule->command('sync:discounts')->daily();
        $schedule->command('sync:promotions')->hourly();
        $schedule->command('sync:stripe')->daily();
        $schedule->command('sync:paypal')->daily();
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
