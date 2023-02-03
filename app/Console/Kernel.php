<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();

        // 毎分
        // $schedule->command('sample-command')->everyMinute()
        //     ->emailOutputTo('info@example.com');
        // 毎時
        // $schedule->command('sample-command')->hourly();
        // 毎時8分
        // $schedule->command('sample-command')->hourlyAt(8);
        // 毎日
        // $schedule->command('sample-command')->daily();
        // 毎日13時
        // $schedule->command('sample-command')->dailyAt('13:00');
        // 毎日3:15(cron表記)
        // $schedule->command('sample-command')->cron('15 3 * * *');

        // テキストp218
        $schedule->command('mail:send-daily-tweet-count-mail')->dailyAt('13:00');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}