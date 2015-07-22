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
        \App\Console\Commands\Inspire::class,
        \App\Console\Commands\Remind::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //$schedule->command('inspire')
        //         ->everyMinute();
        
        //$schedule->command('remind')
        //        ->everyMinute();

        $schedule->command('remind')
                 ->dailyAt('00:31');

       $schedule->command('queue:listen')->dailyAt('00:32');/*->when(function () {
            return true;
        });*/
    }
}
