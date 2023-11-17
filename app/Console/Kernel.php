<?php

namespace App\Console;

use App\Console\Commands\SyncToken;
use App\Console\Commands\SyncStripe;
use App\Console\Commands\SyncPaypal;
use App\Console\Commands\SyncTopups;
use App\Console\Commands\ProcessFiles;
use App\Console\Commands\SyncOperators;
use App\Console\Commands\SyncCountries;
use App\Console\Commands\SyncDiscounts;
use App\Console\Commands\SyncPromotions;
use App\Console\Commands\ProcessRefunds;
use Illuminate\Console\Scheduling\Schedule;
use App\Console\Commands\SyncTopupDIscounts;
use App\Console\Commands\SyncGiftCardProducts;
use App\Console\Commands\SyncGiftTransactions;
use App\Console\Commands\ReCalculateAccountBalances;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        (SyncTopups::class),
        (SyncGiftTransactions::class),
        (SyncTopupDIscounts::class),
        (SyncToken::class),
        (ProcessFiles::class),
        (SyncCountries::class),
        (SyncOperators::class),
        (SyncDiscounts::class),
        (SyncGiftCardProducts::class),
        (SyncPromotions::class),
        (SyncStripe::class),
        (SyncPaypal::class),
        (ProcessRefunds::class),
        (ReCalculateAccountBalances::class)
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('sync:topups')
            ->withoutOverlapping(30);
        $schedule->command('sync:gift_transactions')
            ->withoutOverlapping(30);
        $schedule->command('sync:topup_discounts')
            ->everyMinute()
            ->withoutOverlapping(30);
        $schedule->command('sync:token')
            ->hourly();
        $schedule->command('process:files')
            ->runInBackground()
            ->withoutOverlapping(30);
        $schedule->command('sync:countries')
            ->daily();
        $schedule->command('sync:operators')
            ->daily();
        $schedule->command('sync:discounts')
            ->daily();
        $schedule->command('sync:gift_products')
            ->daily();
        $schedule->command('sync:promotions')
            ->hourly();
        $schedule->command('sync:stripe')
            ->daily();
        $schedule->command('sync:paypal')
            ->daily();
        $schedule->command('process:refunds')
            ->withoutOverlapping(30);
        $schedule->command('calculate:balances')
            ->hourly();
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
