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

    protected $commands = [
        // '\App\Console\Commands\UpdateReceiveStatus',
        // '\App\Console\Commands\updateWeight',
        // '\App\Console\Commands\updateEachStatus',
        // '\App\Console\Commands\updateEachStatusWeekly',
        // '\App\Console\Commands\updateEachStatusMonthly',
        // '\App\Console\Commands\updateEachStatusThreeMonth',
        // '\App\Console\Commands\TrackiFyCronByArrival',
        // '\App\Console\Commands\TrackiFyCronByArrival1',
        // '\App\Console\Commands\TrackiFyCronByArrival2',
        // '\App\Console\Commands\TrackiFyCronByArrivalHourly',
//        '\App\Console\Commands\TrackiFyCronByArrival3',
//        '\App\Console\Commands\TrackiFyCronByArrival4',
//        '\App\Console\Commands\TrackiFyCronByArrival5',
        // '\App\Console\Commands\updateCodBooking',
        // '\App\Console\Commands\OmsArrivalSync',
        // '\App\Console\Commands\OmsArrivalSyncLastDay',
        // '\App\Console\Commands\OmsArrivalSyncLastDay3',
        // '\App\Console\Commands\OmsDispatchSync',
        // '\App\Console\Commands\OmsDispatchSync2',
        // '\App\Console\Commands\SyncOmsCodBooking',
        // '\App\Console\Commands\CreateGstManual',
        // '\App\Console\Commands\PushApiStatus',
        '\App\Console\Commands\SyncHRData',
    ];
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        
        $schedule->command('sync:hrData')->everyTwoMinutes();     // sync HR data
        // $schedule->command('sync:hrData')->everyTenMinutes();     // sync HR data
        // $schedule->command('sync:hrData')->everyMinute();     // sync HR data
        // $schedule->command('sync:hrData')->dailyAt(7);     // sync HR data

        //$schedule->command('default:update-receive-status')->timezone('Asia/Karachi')->everyThirtyMinutes()->runInBackground();
        //$schedule->command('default:update-each-status')->timezone('Asia/Karachi')->everyThirtyMinutes()->runInBackground();
        //$schedule->command('default:update-each-status-weekly')->timezone('Asia/Karachi')->twiceDaily(1, 13)->runInBackground();
        //$schedule->command('default:update-each-status-monthly')->timezone('Asia/Karachi')->twiceDaily(16, 20)->runInBackground();
        //$schedule->command('default:update-each-status-three-month')->timezone('Asia/Karachi')->daily()->runInBackground();

        //$schedule->command('default:update_weight')->timezone('Asia/Karachi')->everyOddHour()->runInBackground();
        //$schedule->command('default:update_weight_weekly')->timezone('Asia/Karachi')->twiceDaily(3, 15)->runInBackground();
        //$schedule->command('default:update_weight_biweekly')->timezone('Asia/Karachi')->dailyAt(7)->runInBackground();

        //$schedule->command('default:cod-live-booking')->timezone('Asia/Karachi')->everyTenMinutes()->runInBackground();
        //$schedule->command('default:trackify_by_arrival')->timezone('Asia/Karachi')->cron('*/40 * * * *')->runInBackground();
        //$schedule->command('default:trackify_by_arrival1')->timezone('Asia/Karachi')->hourly()->runInBackground();
        //$schedule->command('default:trackify_by_arrival2')->timezone('Asia/Karachi')->everyOddHour()->runInBackground();
        //$schedule->command('default:trackify_by_arrival_hourly')->timezone('Asia/Karachi')->everyTenMinutes()->runInBackground();
        //$schedule->command('default:trackify_by_arrival3')->timezone('Asia/Karachi')->everyFifteenMinutes()->runInBackground();
        //$schedule->command('default:trackify_by_arrival4')->timezone('Asia/Karachi')->everyThirtyMinutes()->runInBackground();
        //$schedule->command('default:trackify_by_arrival5')->timezone('Asia/Karachi')->everyThirtyMinutes()->runInBackground();

        //  $schedule->command('default:oms-data-arrival')->timezone('Asia/Karachi')->cron('*/9 * * * *')->runInBackground();
        //  $schedule->command('default:oms-data-arrival2')->timezone('Asia/Karachi')->dailyAt(19)->runInBackground();
        //  $schedule->command('default:oms-data-arrival3')->timezone('Asia/Karachi')->dailyAt(19)->runInBackground();
        //  $schedule->command('default:oms-data-dispatch')->timezone('Asia/Karachi')->everyFifteenMinutes()->runInBackground();
        //  $schedule->command('default:oms-data-dispatch2')->timezone('Asia/Karachi')->twiceDaily(7, 17)->runInBackground();
        //  $schedule->command('default:sync_oms_cod_booking')->timezone('Asia/Karachi')->everyFiveMinutes()->runInBackground();
        //  $schedule->command('default:create_gst_invoice')->timezone('Asia/Karachi')->weekly()->runInBackground();
        //  $schedule->command('default:push-api-status')->timezone('Asia/Karachi')->everyFifteenMinutes()->runInBackground();

        // $schedule->command('default:update-receive-status')->everyTwoMinutes()->runInBackground();
        // $schedule->command('default:update_weight')->everyFiveMinutes()->runInBackground();
        // $schedule->command('default:update-each-status')->everyTenMinutes()->runInBackground();

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
