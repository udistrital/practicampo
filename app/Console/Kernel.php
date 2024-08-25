<?php

namespace PractiCampoUD\Console;

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
        // SendedNotif::class
        // 'PractiCampoUD\Console\Commands\SendedNotif',
        'PractiCampoUD\Console\Commands\CierreProy',
        'PractiCampoUD\Console\Commands\CierreSolic',
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

        // $schedule->command('sended:notif')->everyMinute();
        // $schedule->command('cierre:proy')->dailyAt('13:00');
        $schedule->command('cierre:proy')->everyMinute()
        ->timezone('America/Bogota');

        $schedule->command('cierre:solic')->everyMinute()
        ->timezone('America/Bogota');

        $schedule->command('estudiante:noti')->everyMinute()
        ->timezone('America/Bogota');
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
