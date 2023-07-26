<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Branch;
use App\Models\Setting;
use App\Models\Employee;
use App\Models\Department;
use App\Models\IpRestrict;
use Illuminate\Http\Request;
use App\Models\AttendanceEmployee;
use Illuminate\Support\Facades\DB;
use App\View\Components\ClockInShow;
use Illuminate\Support\Facades\Auth;
use App\View\Components\ClockOutShow;
use Illuminate\Support\Facades\Blade;
use Illuminate\Validation\ValidationException;
use App\DataTables\AttendanceEmployeeDataTable;

class AttendanceEmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index(Request $request)
    {
        $branches = Branch::all()->pluck('name', 'id');
        $department = Department::all()->pluck('name', 'id');

        $employees = Employee::with('user')->whereHas('user', function ($query) {
            $query->where('status', 1);
        });

        if (!empty($request->branch)) {
            $employees->where('branch_id', $request->branch);
        }

        if (!empty($request->department)) {
            $employees->where('department_id', $request->department);
        }

        $employees = $employees->get();

        if (Auth::user()->can('Manage Attendance')) {
            $employee = $employees;

            if (!empty($request->employee)) {
                $employee = $employees->where('id', $request->employee);
            }
            $employee = $employee->pluck('id');

            //dd($request->to);
        } elseif (Auth::user()->can('Show Attendance') and !Auth::user()->hasRole('Super Admin')) {
            $employee = !empty(Auth::user()->employee) ? [Auth::user()->employee->id] : 0;
        } else {
            abort(401);
        }

        $attendanceEmployee = AttendanceEmployee::with('employee.user')->whereIn('employee_id', $employee);

        // if ($request->type == 'monthly' && !empty($request->month)) {
        //     $month = date('m', strtotime($request->month));
        //     $year = date('Y', strtotime($request->month));

        //     $start_date = date($year . '-' . $month . '-01 00:00:00');
        //     $end_date = date($year . '-' . $month . '-t 23:59:59');

        //     $attendanceEmployee->whereBetween('clock_in', [$start_date, $end_date]);
        // } 
        if (!empty($request->from)) {
            $from = $request->from . ' 00:00:00';
            $to = $request->to . ' 23:59:59';
            $attendanceEmployee->whereBetween('clock_in', [$from, $to]);
        } else {
            if (Auth::user()->hrm->type == 'employee') {
                $start_date = date("Y-m-d" . ' 00:00:00');
                $end_date = date("Y-m-d" . ' 23:59:59');
                $attendanceEmployee->whereBetween('clock_in', [$start_date, $end_date]);
            } else {
                $month = date('m');
                $year = date('Y');
                $start_date = date($year . '-' . $month . '-01 00:00:00');
                $end_date = date($year . '-' . $month . '-t 23:59:59');
                $attendanceEmployee->whereBetween('clock_in', [$start_date, $end_date]);
            }
        }

        $attendanceEmployee = $attendanceEmployee->get();

        return view('attendance.index', compact('attendanceEmployee', 'branches', 'department', 'employees'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        if (is_null(auth()->user()->employee)) {
            throw ValidationException::withMessages(['meassage' => 'You have to be an employee to clock in!']);
        }

        $now = now();
        $startTime = now();

        if (
            AttendanceEmployee::where('employee_id', auth()->user()->employee->id)
            ->whereDate('clock_in', $now->format('Y-m-d'))
            ->count() > 0
        ) {
            throw ValidationException::withMessages(['meassage' => 'Cannot clock in multiple time in a day!']);
        }

        if (setting('ip_restrict') == 'on' and IpRestrict::where('ip', $request->ip())->count() == 0) {
            throw ValidationException::withMessages(['meassage' => 'Your ip is not allowed!']);
        }

        $attendance = AttendanceEmployee::create([
            'employee_id' => auth()->user()->employee->id,
            'status' => 1,
            'clock_in' => $now,
            'note' => $request->note,
        ]);

        if (auth()->user()->employee->persist_time == 1) {
            $times = explode(':', auth()->user()->employee->start_time);
            $startTime->setTimeFromTimeString(auth()->user()->employee->start_time);
            $startTime->hour = $times[0];
            $startTime->minute = $times[1];
            $startTime->second = 0;
            if ($startTime < $now) {
                $diffInSec = $now->diffInSeconds($startTime);
                $attendance->late = $diffInSec;
            }
        } elseif (auth()->user()->employee->department->persist_time == 1) {
            $times = explode(':', auth()->user()->department->start_time);
            $startTime->hour = $times[0];
            $startTime->minute = $times[1];
            $startTime->second = 0;
            if ($startTime < $now) {
                $diffInSec = $now->diffInSeconds($startTime);
                $attendance->late = $diffInSec;
            }
        } else {
            // $start_time = json_decode(setting('company_start_time'));
            // $times = explode(':', $start_time->start_time);
            // $startTime->hour = $times[0];
            // $startTime->minute = $times[1];
            // $startTime->second = 0;
            // if ($startTime < $now) {
            //     $diffInSec = $now->diffInSeconds($startTime);
            //     $attendance->late = $diffInSec;
            // }

            $start_time = Auth::user()->employee->shift->start_time;
            $diffInSec = now()->diffInSeconds($start_time);
            $attendance->late = $diffInSec;
        }

        if ($attendance->isDirty()) {
            $attendance->save();
        }

        return response()->json(['time' => $attendance->clock_in->format('Y-m-d h:i A'), 'meassage' => 'Clocked in successfully', 'html' => Blade::renderComponent(new ClockInShow($attendance->clock_in, $attendance->id))], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {
        if (Auth::user()->can('Edit Attendance')) {
            $attendanceEmployee = AttendanceEmployee::where('id', $id)->first();
            $employee_id = $attendanceEmployee->employee_id;
            $employees = Employee::with('user')
                ->where('status', '=', '1')
                ->where('employee_id', $employee_id)
                ->first();
            // $date = date('Y-m-d', strtotime($attendanceEmployee->clock_in));
            //dd($employees);
            return response()->json(['attendance' => $attendanceEmployee, 'employee' => $employees, 'clock_in_date' => $attendanceEmployee->clock_in->format('Y-m-d'), 'clock_in_time' => $attendanceEmployee->clock_in->format('h:i A'), 'clock_out_date' => $attendanceEmployee->clock_out->format('Y-m-d'), 'clock_out_time' => $attendanceEmployee->clock_out->format('h:i A')]);
        } else {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, AttendanceEmployee $attendance)
    {
        $attendance->clock_out = now();

        $diffinSec = $attendance->clock_in->diffInSeconds($attendance->clock_out);

        if (auth()->user()->employee->persist_time == 1) {
            if ($diffinSec > auth()->user()->employee->duration * 3600) {
                $attendance->overtime = $diffinSec - auth()->user()->employee->duration * 3600;
            }
        } elseif (auth()->user()->employee->department->persist_time == 1) {
            if ($diffinSec > auth()->user()->employee->department->duration * 3600) {
                $attendance->overtime = $diffinSec - auth()->user()->employee->department->duration * 3600;
            }
        } else {
            $start_time = json_decode(setting('company_start_time'));
            if ($diffinSec > $start_time->duration * 3600) {
                $attendance->overtime = $diffinSec - $start_time->duration * 3600;
            }
        }

        $attendance->save();

        return response()->json(['time' => $attendance->clock_in->format('Y-m-d h:i A'), 'meassage' => 'Clocked out successfully!', 'html' => Blade::renderComponent(new ClockOutShow($attendance->clock_in, $attendance->clock_out))], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Auth::user()->can('Delete Attendance')) {
            $attendance = AttendanceEmployee::where('id', $id)->first();

            $attendance->delete();

            return response(200);
        } else {
            return response(401);
        }
    }

    public function loadDatatable(AttendanceEmployeeDataTable $datatable)
    {
        return $datatable->ajax();
    }

    public function dailyAttendanceReport()
    {
        if (Auth::user()->can('Manage Attendance')) {
            $attendanceEmployee = Employee::with('user', 'todaysAttendance', 'todayOnLeave')
                ->where('status', 1)
                ->get();

            // dd($attendanceEmployee);
        } else {
            abort(401);
        }
        return view('attendance.daily-attendance-report', compact('attendanceEmployee'));
    }
}
