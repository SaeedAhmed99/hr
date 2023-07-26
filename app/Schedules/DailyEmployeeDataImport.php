<?php

namespace App\Schedules;

use Artisan;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Leave;
use App\Models\AttendanceEmployee;
use Illuminate\Support\Facades\DB;

class DailyEmployeeDataImport
{
    public function __invoke()
    {
        $users = User::where('id', '!=', 1)->get();

        $attend_user = $users->take(5);
        $attendence_user = $attend_user->take(3);

        //dd($attendence_user);

        foreach ($attendence_user as $user) {
            $attendence = new AttendanceEmployee();
            $attendence->employee_id = $user->employee->id;
            $attendence->clock_in = Carbon::now()->subMinutes(rand(1, 55));
            $attendence->status = 1;
            //dd($attendence);
            $attendence->save();
        }
        $late_user = $attend_user->take(-2);
        foreach ($late_user as $user) {
            $attendence = new AttendanceEmployee();
            $attendence->employee_id = $user->employee->id;
            $attendence->clock_in = Carbon::now()->subMinutes(rand(1, 55));
            $to="09:00";
            $attendence->late = $to->diffInMinutes($attendence->clock_in);
            $attendence->status = 1;
            //dd($attendence);
            $attendence->save();
        }

        $leave_user = $users->take(-2);
        //dd($late_user);
        foreach ($leave_user as $user) {
            $leave = new Leave();
            $leave->employee_id = $user->employee->id;
            $leave->leave_type_id = 4;
            $leave->start_date = now()->format('Y-m-d');
            $leave->end_date = now()
                ->addDays(2)
                ->format('Y-m-d');
            $leave->status = 1;
            $leave->total_leave_days = 2;
            $leave->leave_reason = 'sick';
            //dd($leave);
            $leave->save();
        }
    }
}
