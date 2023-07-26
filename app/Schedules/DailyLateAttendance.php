<?php

namespace App\Schedules;

use Mail;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Shift;
use App\Models\Employee;
use App\Mail\LateEmployeeListMail;
use App\Models\AttendanceEmployee;
use Illuminate\Support\Facades\Auth;

class DailyLateAttendance
{
    public function __invoke()
    {
        $employees = Employee::where('status', 1)->get();

        foreach ($employees as $employee) {
            $attendance = AttendanceEmployee::where('employee_id', $employee->id)->whereDate('clock_in', now())->whereTime('clock_in', '<=', now())->first();

            if ($attendance == null) {
                $allLateEmployees[] = $employee;
                $lateEmployee = $employee;

                $employeeMailData = [
                    'title' => 'Notice of Missed Shift- Urgent Action Required',
                    'lateEmployees' => $lateEmployee,
                ];

                Mail::to($employee->user->email)->send(new LateEmployeeListMail($employeeMailData));
            }
        }

        $allLateEmployeesMailData = [
            'title' => 'Employee Absence Notification- Urgent Action Requested',
            'lateEmployees' => $allLateEmployees,
        ];

        $superAdmin = User::where('name', 'Super Admin')->first();

        Mail::to($superAdmin->email)->send(new LateEmployeeListMail($allLateEmployeesMailData));
    }
}
