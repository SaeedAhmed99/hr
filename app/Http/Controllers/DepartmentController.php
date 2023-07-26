<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\DataTables\DepartmentDataTable;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->can('Manage Department')) {
            $branches = Branch::all();

            return view('department.index', compact('branches'));
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
        if (Auth::user()->can('Create Department')) {
            $branches = Branch::all();

            return view('department.create', compact('branches'));
        } else {
            return response()->json(['error' => __('Permission denied.')], 401);
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
        if (Auth::user()->can('Create Department')) {
            $request->validate(
                [
                    'name' => 'required',
                    'branch' => 'required',
                ],
                [
                    'name.required' => 'Name is required',
                    'branch.required' => 'Branch is required',
                ],
            );

            $department = new Department();
            $department->name = $request->name;
            $department->branch_id = $request->branch;
            $department->save();

            return redirect()
                ->route('department.index')
                ->with('success', __('Department  successfully created.'));
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
        if (Auth::user()->can('Edit Department')) {
            $department = Department::find($id);
            return response()->json($department);
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
        if (Auth::user()->can('Edit Department')) {
            $request->validate([
                'branch_update' => 'required',
                'name_update' => 'required',
            ]);
            $department = Department::findOrFail($id);
            $department->branch_id = $request->branch_update;
            $department->name = $request->name_update;
            $department->save();

            return redirect()
                ->route('department.index')
                ->with('success', __('Department successfully updated.'));
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
        if (Auth::user()->can('Delete Department')) {
            $department = Department::findOrFail($id);
            $department->delete();

            return redirect()
                ->route('department.index')
                ->with('success', __('Department successfully deleted.'));
        } else {
            return redirect()
                ->back()
                ->with('error', __('Permission denied.'));
        }
    }

    public function loadDatatable(DepartmentDataTable $datatable)
    {
        return $datatable->ajax();
    }

    public function fetchDepartment($branch_id)
    {
        $all_department = Department::where('branch_id', $branch_id)->get();
        return($all_department);
    }    

    public function fetchDepartmentFromBranches(Request $request)
    {
        if(is_null($request->branches)){
            return response("");
        }
        // return response($request->branches);
        $branch_wise_department = Department::whereIn('branch_id', $request->branches)->get();
        $html = "";
        foreach($branch_wise_department as $department){
            $html .= "<option value='".$department->id."'>".$department->name."</option>";
        }
        return response($html);
    }
}
