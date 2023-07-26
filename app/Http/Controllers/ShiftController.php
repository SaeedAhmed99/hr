<?php

namespace App\Http\Controllers;

use Mail;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Shift;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\DataTables\ShiftDatatable;
use App\Mail\LateEmployeeListMail;
use App\Models\AttendanceEmployee;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;

class ShiftController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employee = Employee::where('id', 3)->first();

        // dd($employee->department->name);
        return view('shift.index');
    }

    public function loadDatatable(ShiftDatatable $datatable)
    {
        return $datatable->ajax();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Artisan::call("schedule:work");
        try {
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

                    //Mail::to($employee->user->email)->send(new LateEmployeeListMail($employeeMailData));
                    Mail::to("ropuco@birtmail.com")->send(new LateEmployeeListMail($employeeMailData));
                }
            }

            // $allLateEmployeesMailData = [
            //     'title' => 'Employee Absence Notification- Urgent Action Requested',
            //     'lateEmployees' => $allLateEmployees,
            // ];

            // $superAdmin = User::where('name', 'Super Admin')->first();

            // Mail::to($superAdmin->email)->send(new LateEmployeeListMail($allLateEmployeesMailData));
        } catch (\Exception $e) {
            return $e;
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // try {
        $shift = new Shift();

        $shift->name = $request->name;
        $shift->start_time = $request->start_time;
        $shift->end_time = $request->end_time;
        $shift->buffer_time = $request->buffer_time;
        $shift->description = $request->description;

        $shift->save();

        return response('Shift Created Successfully', 201);
        // } catch (\Exception $e) {
        // return $e;
        // }
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
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Auth::user()->can('Edit Shift')) {
            $shift = Shift::find($id);
            if (Auth::user()->timezone) {
                $shift->start_time = Carbon::parse($shift->start_time)->timezone(Auth::user()->timezone)->toTimeString() . '';
            } else {
                $shift->start_time = Carbon::parse($shift->start_time)->timezone(setting('timezone'))->toTimeString() . '';
            }

            if (Auth::user()->timezone) {
                $shift->end_time = Carbon::parse($shift->end_time)->timezone(Auth::user()->timezone)->toTimeString() . '';
            } else {
                $shift->end_time = Carbon::parse($shift->end_time)->timezone(setting('timezone'))->toTimeString() . '';
            }

            return response()->json($shift);
        } else {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $shift = Shift::find($id);

        $shift->name = $request->name;
        $shift->start_time = $request->start_time;
        $shift->end_time = $request->end_time;
        $shift->buffer_time = $request->buffer_time;
        $shift->description = $request->description;

        $shift->save();
        return response('Shift Upadated Successfully', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $shift = Shift::find($id);
            $shift->delete();

            return response('Shift Deleted Successfully', 200);
        } catch (\Exception $e) {
            return $e;
        }
    }
}
