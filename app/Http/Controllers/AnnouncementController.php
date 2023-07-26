<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Notice;
use App\Models\Employee;
use App\Mail\MeetingMail;
use App\Models\Department;
use App\Models\Announcement;
use Illuminate\Http\Request;
use App\Models\AnnouncementBranch;
use App\Models\AnnouncementEmployee;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\AnnouncementDepartment;
use App\DataTables\AnnouncementDataTable;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->can('Manage Announcement')) {
            $branches = Branch::all();
            $departments = Department::all();
            $employees = Employee::all();
            return view('announcement.index', compact('branches', 'departments', 'employees'));
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
        if (Auth::user()->can('Create Announcement')) {
            $request->validate([
                'branch' => 'required',
                'department' => 'required',
                'employee' => 'required',
                'start_date' => 'required',
                'end_date' => 'required',
                'title' => 'required',
            ]);

            //dd($request);

            $branches = [];
            $dipartments = [];
            $employees = [];

            $announcement = new Announcement();
            $announcement->title = $request->title;
            $announcement->start_date = $request->start_date;
            $announcement->end_date = $request->end_date;
            $announcement->description = $request->description;
            $announcement->save();

            foreach ($request->branch as $branch) {
                $branches[] = [
                    'announcement_id' => $announcement->id,
                    'branch_id' => $branch,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            AnnouncementBranch::insert($branches);

            foreach ($request->department as $department) {
                $dipartments[] = [
                    'announcement_id' => $announcement->id,
                    'department_id' => $department,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            AnnouncementDepartment::insert($dipartments);
            $notices = [];
            foreach ($request->employee as $employee) {
                $employees[] = [
                    'announcement_id' => $announcement->id,
                    'employee_id' => $employee,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                $mailData = [
                    'title' => 'Annoucement for ' . $announcement->title . '',
                    'body' => 'There is a Announcement please check your portal.',
                ];

                $notices[] = [
                    'type' => "Announcement",
                    'title' => $announcement->title,
                    'body' => $announcement->description,
                    'notice_date' => $announcement->start_date,
                    'employee_id' => $employee,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                Mail::to($employee->user->email)->send(new MeetingMail($mailData));
            }
            
            AnnouncementEmployee::insert($employees);
            Notice::insert($notices);

            return response('Announcement Created Successfully', 201);
        } else {
            abort(401);
        }
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
        if (Auth::user()->can('Edit Announcement')) {
            $announcement = Announcement::find($id);

            return response()->json($announcement);
        } else {
            abort(401);
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
        if (Auth::user()->can('Edit Announcement')) {
            $request->validate([
                'title_update' => 'required',
                'start_date_update' => 'required',
                'end_date_update' => 'required',
            ]);
            $announcement = Announcement::find($id);
            //dd($request);
            $announcement->title = $request->title_update;
            $announcement->start_date = $request->start_date_update;
            $announcement->end_date = $request->end_date_update;
            $announcement->description = $request->description_update;
            $announcement->save();

            return response('Announcement Updated Successfully', 200);
        } else {
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
        if (Auth::user()->can('Delete Announcement')) {
            $announcement = Announcement::findOrFail($id);
            $announcement_branch = AnnouncementBranch::where('announcement_id', '=', $id);
            $announcement_department = AnnouncementDepartment::where('announcement_id', '=', $id);
            $announcement_employee = AnnouncementEmployee::where('announcement_id', '=', $id);
            $announcement->delete();
            $announcement_branch->delete();
            $announcement_department->delete();
            $announcement_employee->delete();

            return response('Announcement Deleted Successfully', 200);
        } else {
            abort(401);
        }
    }

    public function loadDatatable(AnnouncementDataTable $datatable)
    {
        return $datatable->ajax();
    }
}
