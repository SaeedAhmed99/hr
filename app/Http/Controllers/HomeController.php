<?php

namespace App\Http\Controllers;

use DB;
use Carbon\Carbon;
use App\Models\Leave;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Models\AttendanceEmployee;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        return view('index');
    }

    public function home()
    {
        $todays_attendance = auth()->user()->employee
            ? AttendanceEmployee::whereDate('clock_in', now()->format('Y-m-d'))
            ->where('employee_id', auth()->user()->employee->id)
            ->first()
            : null;

        $employee_count = Employee::with('todayOnLeave')->count();
        $leave_employee_count = Leave::whereDate('start_date', '<=', Carbon::today())->whereDate('end_date', '>=', Carbon::today())->where('status', 1)->count();
        return view('dashboard', compact('todays_attendance', 'employee_count', 'leave_employee_count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
