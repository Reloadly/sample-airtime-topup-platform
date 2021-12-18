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
        $schedule->command('sync:topups')->withoutOverlapping(30);
        $schedule->command('sync:gift_transactions')->withoutOverlapping(30);
        $schedule->command('sync:topup_discounts')->everyMinute()->withoutOverlapping(30);
        $schedule->command('sync:token')->hourly();
        $schedule->command('process:files')->runInBackground()->withoutOverlapping(30);
        $schedule->command('sync:countries')->daily();
        $schedule->command('sync:operators')->daily();
        $schedule->command('sync:discounts')->daily();
        $schedule->command('sync:gift_products')->daily();
        $schedule->command('sync:promotions')->hourly();
        $schedule->command('sync:stripe')->daily();
        $schedule->command('sync:paypal')->daily();
        $schedule->command('process:refunds')->withoutOverlapping(30);
        $schedule->command('calculate:balances')->hourly();
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
