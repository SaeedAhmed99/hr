<?php

namespace App\Console;

use Carbon\Carbon;
use App\Models\Shift;
use App\Schedules\DailyDbImport;
use App\Schedules\PromoteEmployee;
use App\Schedules\TransferEmployee;
use Illuminate\Support\Facades\Auth;
use App\Schedules\DailyLateAttendance;
use App\Schedules\DailyEmployeeDataImport;
use Illuminate\Console\Scheduling\Schedule;
use App\Schedules\ResignationEmployeeStatus;
use App\Schedules\TerminationEmployeeStatus;
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
        $schedule->call(new ResignationEmployeeStatus())->dailyAt('00:00');
        $schedule->call(new TerminationEmployeeStatus())->dailyAt('00:00');
        $schedule->call(new PromoteEmployee())->dailyAt('00:00');
        $schedule->call(new TransferEmployee())->dailyAt('00:10');
        $schedule->call(new DailyEmployeeDataImport())->dailyAt('09:00');

        $shifts = Shift::all();

        foreach ($shifts as $shift) {
            $start_time = Carbon::parse($shift->start_time)->addMinutes($shift->buffer_time)->format('H:i');
            $schedule->call(new DailyLateAttendance())->dailyAt($start_time);
        }

        // $schedule->call(new DailyDbImport())->dailyAt('00:30');

        // $schedule->call(function () {
        //     Mail::to("ropuco@birtmail.com")->send(new MeetingMail(['title' => 'title', 'body' => 'body']));
        // })->everyMinute();

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
