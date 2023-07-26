<?php

namespace App\Http\Controllers;

use App\Models\EmployeeProject;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class EmployeeProjectController extends Controller
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
        $request->validate(
            [
                'search' => 'required|array',
                'project_for_employee' => 'required',
            ],
            [
                'search.required' => 'Assign atleast one employee!',
                'project_for_employee.required' => 'Something went wrong! Please reload!'
            ]
        );

        $employee_project = [];
        if(EmployeeProject::where('project_id', $request->project_for_employee)->whereIn('employee_id', $request->search)->count()){
            throw ValidationException::withMessages(['search' => 'Some employee are already assigned to this project!']);
        };
        
        foreach($request->search as $search){
            $employee_project[] = [
                'employee_id' => $search,
                'project_id' => $request->project_for_employee,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        EmployeeProject::insert($employee_project);

        return response("Successfully added employee", 200);
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
    public function update(Request $request, EmployeeProject $id)
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
