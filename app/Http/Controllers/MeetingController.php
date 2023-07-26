<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Meeting;
use App\Models\Employee;
use App\Mail\MeetingMail;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Models\MeetingBranch;
use App\Models\MeetingEmployee;
use App\Models\MeetingDepartment;
use App\DataTables\MeetingDataTable;
use App\Models\Notice;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class MeetingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->can('Manage Meeting') or Auth::user()->can('Show Meeting')) {
            $branches = Branch::all();
            $departments = Department::all();
            $employees = Employee::all();
            return view('meeting.index', compact('branches', 'departments', 'employees'));
        } else {
            return redirect()
                ->back()
                ->with('error', __('Permission denied.'));
        }
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
        if (Auth::user()->can('Create Meeting')) {
            $request->validate([
                'branch' => 'required',
                'department' => 'required',
                'employee' => 'required',
                'date' => 'required',
                'time' => 'required',
                'title' => 'required',
            ]);

            //dd($request);

            $branches = [];
            $dipartments = [];
            $employees = [];


            $meeting = new Meeting();
            $meeting->title = $request->title;
            $meeting->date = $request->date;
            $meeting->time = $request->time;
            $meeting->description = $request->description;
            $meeting->save();

            foreach ($request->branch as $branch) {
                $branches[] = [
                    'meeting_id' => $meeting->id,
                    'branch_id' => $branch,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            MeetingBranch::insert($branches);

            foreach ($request->department as $department) {
                $dipartments[] = [
                    'meeting_id' => $meeting->id,
                    'department_id' => $department,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            MeetingDepartment::insert($dipartments);

            $notices = [];
            $meeting_employees = Employee::with('user')->whereIn('id', $request->employee)->get();
            foreach ($meeting_employees as $employee) {
                $employees[] = [
                    'meeting_id' => $meeting->id,
                    'employee_id' => $employee->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                $mailData = [
                    'title' => 'Meeting for ' . $meeting->title,
                    'body' => $meeting->description,
                ];

                $notices[] = [
                    'type' => "Meeting",
                    'title' => $meeting->title,
                    'body' => $meeting->description,
                    'notice_date' => $meeting->date,
                    'notice_time' => $meeting->time,
                    'employee_id' => $employee->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                Mail::to($employee->user->email)->send(new MeetingMail($mailData));
            }

            MeetingEmployee::insert($employees);
            Notice::insert($notices);

            return redirect()
                ->route('trainer.index')
                ->with('success', __('Trainer  successfully created.'));
        } else {
            return redirect()
                ->back()
                ->with('error', __('Permission denied.'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show($meeting)
    {
        $meeting = Meeting::with('meeting_braches.branch', 'meeting_departments.department', 'meeting_employees.employee.user')->find($meeting);
        // dd($meeting);
        return view('meeting.show', compact('meeting'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Auth::user()->can('Edit Meeting')) {
            $meeting = Meeting::find($id);

            return response()->json($meeting);
        } else {
            return redirect()
                ->back()
                ->with('error', __('Permission denied.'));
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
        if (Auth::user()->can('Edit Meeting')) {
            $request->validate([
                'title_update' => 'required',
                'date_update' => 'required',
                'time_update' => 'required',
            ]);
            $meeting = Meeting::find($id);
            //dd($request);
            $meeting->title = $request->title_update;
            $meeting->date = $request->date_update;
            $meeting->time = $request->time_update;
            $meeting->description = $request->description_update;
            $meeting->save();

            return redirect()
                ->route('meeting.index')
                ->with('success', __('Training successfully updated.'));
        } else {
            return redirect()
                ->back()
                ->with('error', __('Permission denied.'));
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
        if (Auth::user()->can('Delete Meeting')) {
            $meeting = Meeting::findOrFail($id);
            $meeting_branch = MeetingBranch::where('meeting_id', '=', $id);
            $meeting_department = MeetingDepartment::where('meeting_id', '=', $id);
            $meeting_employee = MeetingEmployee::where('meeting_id', '=', $id);
            $meeting->delete();
            $meeting_branch->delete();
            $meeting_department->delete();
            $meeting_employee->delete();

            return redirect()
                ->route('training.index')
                ->with('success', __('Training successfully deleted.'));
        } else {
            return redirect()
                ->back()
                ->with('error', __('Permission denied.'));
        }
    }
    public function loadDatatable(MeetingDataTable $datatable)
    {
        return $datatable->ajax();
    }
}
