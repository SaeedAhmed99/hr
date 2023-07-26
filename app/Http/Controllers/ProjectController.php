<?php

namespace App\Http\Controllers;

use App\Models\EmployeeProject;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function PHPUnit\Framework\isEmpty;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        // dd(Auth::user()->hrm);
        // if (Auth::user()->can('Manage Project')) {
        if (Auth::user()->hrm->type == 'employee') {
            $user = 'employee';
            $employeeProjects = EmployeeProject::where('employee_id', Auth::user()->employee->id)->where('is_active', 1)->get();
            foreach ($employeeProjects as $employeeProject) {
                $employeeProjectIds[] = $employeeProject->project_id;
            }

            if (!empty($employeeProjectIds)) {
                $projects = Project::with('employees.user')->whereIn('id', $employeeProjectIds)->get();
            } else {
                $projects = [];
            }
            // dd($projects);
        } else {
            $user = 'company';
            $projects = Project::with('employees.user')->get();


            // dd($projects);
        }
        // }

        // dd($projects);
        return view('project.index', compact('projects', 'user'));
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
     * @return \Illuminate\Contracts\View\Factory
     */
    public function store(Request $request)
    {
        if (Auth::user()->can('Create Project')) {
            $project = new Project();
            $project->title = $request->project_title;
            $project->description = $request->project_description;
            $project->created_by = Auth::user()->id;

            if ($request->hasFile('project_logo')) {
                $file = $request->file('project_logo');
                $extention = $file->getClientOriginalExtension();

                //naming file
                $project_title = $project->title;
                $project_title = explode(" ", $project_title);
                $project_title = $project_title[0];
                $project_title = strtolower($project_title);

                $filename = time() . '_' . $project_title . '_' . Auth::user()->id . '.' . $extention;
                $file->move('uploaded_files/project_logo/', $filename);

                $project->project_logo = $filename;
            }

            $project->save();

            //Adding creator to project
            // $project_people = new EmployeeProject();
            // $project_people->project_id = $project->id;
            // $project_people->employee_id = Auth::user()->employee->id;
            // $project_people->save();

            // if ($project->save()) {
            //     session()->flash('success', 'Project added successfully.');
            // } else {
            //     session()->flash('warning', 'Errot adding project!! Please try again later.');
            // }

            session()->flash('success', 'Project added successfully.');

            return redirect(route('project.index'));
        } else {
            return redirect()
                ->back()
                ->with('error', 'Permission denied.');
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
    public function destroy(Project $project)
    {
        $project->delete();
    }

    public function removeProjectEmployee(Request $request)
    {
        if (Auth::user()->can('Update Project')) {
            EmployeeProject::where('id', $request->project)->update([
                'is_active' => 0
            ]);

            return response("Removed employee from project!");
        } else {
            return redirect()
                ->back()
                ->with('error', 'Permission denied.');
        }
    }

    public function reassignProjectEmployee(Request $request)
    {
        if (Auth::user()->can('Update Project')) {
            EmployeeProject::where('id', $request->project)->update([
                'is_active' => 1
            ]);

            return response("Reassigned employee to this project!");
        } else {
            return redirect()
                ->back()
                ->with('error', 'Permission denied.');
        }
    }
}
