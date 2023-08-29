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
        '\App\Console\Commands\PayLoanEmi',
        '\App\Console\Commands\CheckInvestMaturity',
        '\App\Console\Commands\CheckLoanRequestExpiry',
        '\App\Console\Commands\UpdateTransferStatus',
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
        $schedule->command('command:PayLoanEmi')->dailyAt('00:05');
        $schedule->command('command:CheckInvestMaturity')->dailyAt('00:15');
        $schedule->command('command:CheckLoanRequestExpiry')->everyMinute();
        $schedule->command('command:UpdateTransferStatus')->dailyAt('00:35');
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
