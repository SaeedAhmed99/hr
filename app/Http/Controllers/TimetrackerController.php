<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Employee;
use App\Models\TimeTracker;
use Illuminate\Http\Request;
use App\Models\EmployeeProject;
use Illuminate\Support\Facades\Auth;

class TimetrackerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Employee $employee, Request $request)
    {
        $date = null;
        // $project_ids = [];
        // $projects = Project::where('user_id', Auth::user()->id)
        //     ->selectRaw('id')
        //     ->get();

        // foreach ($projects as $project) {
        //     array_push($project_ids, $project->id);
        // }

        $timeTrackers = TimeTracker::with([
            'screenshots' => function ($q) {
                $q->latest();
            }
        ])
            // ->whereIn('project_id', $project_ids)
            ->whereHas('employeeProjects', function ($query) use ($employee) {
                $query->where('employee_id', $employee->id);
            })
            // ->whereHas('project', function ($q) {
            //     $q->where('user_id', Auth::user()->id);
            // })
            ->orderBy('id', 'desc');

        if (isset($request->from)) {

            $from = $request->from;
            $to = $request->to;

            // $timeTrackers->whereDate('start', $request->date);

            $timeTrackers->whereDate('start', '>=', $from);
            $timeTrackers->whereDate('start', '<=', $to);

            // $timeTrackers->whereBetween('start', [$from, $to]);
            $date = $request->date;
        }

        $timeTrackers = $timeTrackers->get();

        // $user = User::findOrFail($employee->id);

        return view('timetracker.index', [
            'timeTrackers' => $timeTrackers,
            'employee' => $employee,
            'date' => $date,
        ]);
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

    public function projectWiseEmployee(EmployeeProject $employeeProject, Request $request)
    {
        $date = null;
        $timeTrackers = TimeTracker::with([
            'screenshots' => function ($q) {
                $q->latest();
            }
        ])->whereHas('employeeProjects', function ($query) use ($employeeProject) {
            $query->where('id', $employeeProject->id);
        })->orderBy('id', 'desc');

        $employee = Employee::findOrFail($employeeProject->employee_id);
        $project = Project::findOrFail($employeeProject->project_id);

        if (isset($request->employee_project_id)) {
            $timeTrackers = TimeTracker::with('screenshots')->where('employee_project_id', $request->employee_project_id)->orderBy('id', 'desc');
            $employeeProject = EmployeeProject::with('employee')->where('id', $request->employee_project_id)->first();
            $employee = $employeeProject->employee;
            $project = $employeeProject->project;
        }

        if (isset($request->from)) {
            $from = $request->from;
            $to = $request->to;

            $timeTrackers->whereDate('start', '>=', $from);
            $timeTrackers->whereDate('start', '<=', $to);
        }

        $timeTrackers = $timeTrackers->get();
        if (Auth::user()->hrm->type == 'employee') {
            $projectEmployees = EmployeeProject::with('employee', 'project')->where('employee_id', $employeeProject->employee_id)->get();
        } else {
            $projectEmployees = EmployeeProject::with('employee', 'project')->where('project_id', $employeeProject->project_id)->get();
        }

        // dd($projectEmployees);

        return view('timetracker.index-w-project', [
            'timeTrackers' => $timeTrackers,
            'employee' => $employee,
            'project' => $project,
            'date' => $date,
            'employee_project_id' => $employeeProject->id,
            'projectEmployees' => $projectEmployees
        ]);
    }
}
