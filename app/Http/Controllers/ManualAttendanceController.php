<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\AttendanceEmployee;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ManualAttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $attendance)
    {
        if (Auth::user()->can("Update Attendance")) {
            $attendance = AttendanceEmployee::with('employee')->find($attendance);
            $request->validate([
                'clock_in_date' => 'required',
                'clock_in_time' => 'required',
                'clock_out_date' => 'required',
                'clock_out_time' => 'required',
            ]);

            $clock_in = Carbon::createFromFormat('Y-m-d H:i A', $request->clock_in_date . " " . $request->clock_in_time);
            $clock_out = Carbon::createFromFormat('Y-m-d H:i A', $request->clock_out_date . " " . $request->clock_out_time);

            if ($clock_in > $clock_out) {
                throw ValidationException::withMessages(['clock_in_date' => 'Clock in time cannot be greater then clock out time!']);
            }

            $attendance->clock_in = $clock_in;
            $attendance->clock_out = $clock_out;
            $attendance->overtime = 0;

            $diff = $attendance->clock_in->diff($attendance->clock_out);

            if ($attendance->employee->persist_time == 1) {
                if ($diff->h > $attendance->employee->duration) {
                    $attendance->overtime = ($diff->h - $attendance->employee->duration);
                }
            } else if ($attendance->employee->department->persist_time == 1) {
                if ($diff->h > $attendance->employee->department->duration) {
                    $attendance->overtime = ($diff->h - $attendance->employee->department->duration);
                }
            } else {
                $start_time = json_decode(setting('company_start_time'));
                if ($diff->h > $start_time->duration) {
                    $attendance->overtime = ($diff->h - $start_time->duration);
                }
            }

            $attendance->save();

            return response()->json(['time' => $attendance->clock_in->format("Y-m-d h:i A"), 'meassage' => "Updated successfully!"], 200);
        }else{
            abort(401);
        }
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
