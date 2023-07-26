<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;
use App\DataTables\BranchDataTable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->can('Manage Branch')) {
            return view('branch.index');
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
        if (Auth::user()->can('Create Branch')) {
            return view('branch.create');
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
        if (Auth::user()->can('Create Branch')) {
            $request->validate([
                'name' => 'required',
                'branch_code' => 'required',
            ]);

            $branch = new Branch();
            $branch->name = $request->name;
            $branch->branch_code = $request->branch_code;
            if (empty($request->order)) {
                $branch->order = 1;
            } else {
                $branch->order = $request->order;
            }

            $branch->save();

            return redirect()
                ->back()
                ->with('success', __('Branch  successfully created.'));
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
        if (Auth::user()->can('Edit Branch')) {
            $branch = Branch::find($id);
            return response()->json($branch);
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
        if (Auth::user()->can('Edit Branch')) {
            $request->validate([
                'name_update' => 'required',
                'branch_code_update' => 'required'
            ]);
            $branch = Branch::findOrFail($id);
            $branch->name = $request->name_update;
            $branch->branch_code = $request->branch_code_update;
            $branch->order = $request->order_update;
            $branch->save();

            return redirect()
                ->route('branch.index')
                ->with('success', __('Branch successfully updated.'));
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
        if (Auth::user()->can('Delete Branch')) {
            $branch = Branch::findOrFail($id);
            $branch->delete();
            Session::flash('success', __('Branch successfully deleted.'));
            //$request->session()->flash('success', __('Branch successfully deleted.'));
        } else {
            return redirect()
                ->back()
                ->with('error', __('Permission denied.'));
        }
    }

    public function loadDatatable(BranchDataTable $datatable)
    {
        return $datatable->ajax();
    }
}
