<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Designation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\DataTables\DesignationDataTable;

class DesignationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->can('Manage Designation')) {
            //$departments = Department::with('designations')->get();
            $departments = Department::all();

            return view('designation.index', compact('departments'));
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
        if (Auth::user()->can('Create Designation')) {
            $departments = Department::all();
            return view('designation.create', compact('departments'));
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
        if (Auth::user()->can('Create Designation')) {
            $request->validate([
                'name' => 'required',
            ]);

            $designation = new Designation();
            $designation->grade = $request->grade;
            $designation->name = $request->name;
            $designation->save();

            return redirect()
                ->route('designation.index')
                ->with('success', __('Designation  successfully created.'));
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
        if (Auth::user()->can('Edit Designation')) {
            $designation = Designation::find($id);
            return response()->json($designation);
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
        if (Auth::user()->can('Edit Designation')) {
            $request->validate(
                [
                    'name_update' => 'required',
                ]
            );
            $designation = Designation::findOrFail($id);
            $designation->name = $request->name_update;
            $designation->grade = $request->grade_update;
            $designation->save();

            return redirect()
                ->route('designation.index')
                ->with('success', __('Designation  successfully updated.'));
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
        if (Auth::user()->can('Delete Designation')) {
            $designation = Designation::findOrFail($id);
            $designation->delete();

            return redirect()
                ->route('designation.index')
                ->with('success', __('Department successfully deleted.'));
        } else {
            return redirect()
                ->back()
                ->with('error', __('Permission denied.'));
        }
    }

    public function loadDatatable(DesignationDataTable $datatable)
    {
        return $datatable->ajax();
    }
}
