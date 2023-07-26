<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Leave;
use App\Models\Notice;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Models\AttendanceEmployee;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class GraphController extends Controller
{
    public function departmentWiseEmployee()
    {
        $department_wise_employee = Employee::select(DB::raw("count(*) as number_of_employee, departments.name"))->join('departments', 'departments.id', '=', 'employees.department_id')->groupBy('departments.name')->get();
        return response()->json([
            'series' => $department_wise_employee->pluck('number_of_employee')->toArray(),
            'label' => $department_wise_employee->pluck('name')->toArray()
        ]);
    }

    public function designationWiseEmployee()
    {
        $designation_wise_employee = Employee::select(DB::raw("count(*) as number_of_employee, designations.name"))->join('designations', 'designations.id', '=', 'employees.designation_id')->groupBy('designation_id')->get();
        return response()->json([
            'series' => $designation_wise_employee->pluck('number_of_employee')->toArray(),
            'label' => $designation_wise_employee->pluck('name')->toArray()
        ]);
    }

    public function todayEmployeeAttendance()
    {
        $employees = Employee::count();
        $present = AttendanceEmployee::whereDate('clock_in', Carbon::today())->get();
        $onLeaveToday = Leave::where('start_date', '<=', now()->format("Y-m-d"))->where('end_date', '>=', now()->format("Y-m-d"))->where('status', 1)->count();
        return response()->json([
            'series' => [$employees, $present->count(), $present->whereNull('late')->count(), $onLeaveToday],
            'label' => ['Total employee', 'Present', 'On Time', 'On Leave']
        ]);
    }

    public function lastAnnouncements()
    {
        if (auth()->user()->employee) {
            $announcements = Notice::where('employee_id', auth()->user()->employee->id)->where('seen', 0)->orderBy("notice_date", "desc")->get();
        } else {
            $announcements = collect();
        }

        return view('components.announcements')->with('announcements', $announcements);
    }

    public function employeeWorkHour()
    {
        if(!Auth::user()->isEmployee()){
            return response()->json(["employee" => false]);
        }
        $setting_week_start_day = setting("week_start_day");
        if ($setting_week_start_day) {
            $week_start = Carbon::parse("last $setting_week_start_day");
        } else {
            $week_start = Carbon::parse('last sunday');
        }

        $attendances = AttendanceEmployee::whereDate('clock_in', ">=", $week_start->format("Y-m-d"))->where('employee_id', auth()->user()->employee->id)->get();
        $total_week_hour = 0;
        $total_week_minute = 0;
        $today_clocked_out = true;
        $total_today_seconds = 0;
        foreach ($attendances as $attendance) {
            $clock_in = new Carbon($attendance->clock_in);
            if(is_null($attendance->clock_out)){
                $clock_out = new Carbon($attendance->clock_in);
            }else{
                $clock_out = new Carbon($attendance->clock_out);
            }
            $diff = $clock_out->diff($clock_in);
            $total_week_hour += $diff->h;
            $total_week_minute += $diff->i;
            if(str_contains($attendance->clock_in, now()->format("Y-m-d"))){
                $diff = $clock_out->diffInSeconds($clock_in);
                if(is_null($attendance->clock_out)){
                    $diff = now()->diffInSeconds($clock_in);
                    $today_clocked_out = false;
                }
                $total_today_seconds += $diff;
            }
        }

        return response()->json([
            'employee' => true,
            'week' => $total_week_hour."h : ".$total_week_minute."m",
            'today' => $total_today_seconds,
            'today_clock_out' => $today_clocked_out
        ]);
    }


    public function shedule()
    {
       $users = User::where('id', '!=', 1)->get();

        $attend_user = $users->take(5);
        $attendence_user = $attend_user->take(3);

        //dd($attendence_user);

        foreach ($attendence_user as $user) {
            $attendence = new AttendanceEmployee();
            $attendence->employee_id = $user->employee->id;
            $attendence->clock_in = Carbon::now()->subMinutes(rand(-60, +60));
            $attendence->status = 1;
            //dd($attendence);
            $attendence->save();
        }
        $late_user = $attend_user->take(-2);
        foreach ($late_user as $user) {
            $attendence = new AttendanceEmployee();
            $attendence->employee_id = $user->employee->id;
            $attendence->clock_in = Carbon::now()->subMinutes(rand(-60, +60));
            //dd(diffInMinutes($attendence->clock_in));
            $to=new Carbon('09:00:00');
            $attendence->late = $to->diffInSeconds($attendence->clock_in);
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
