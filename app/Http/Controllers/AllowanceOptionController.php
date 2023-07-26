<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AllowanceOption;
use Illuminate\Support\Facades\Auth;
use App\DataTables\AllowanceOptionDataTable;

class AllowanceOptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->can('Manage Allowance Option')) {
            return view('allowanceoption.index');
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
        if (Auth::user()->can('Create Allowance Option')) {
            return view('allowanceoption.create');
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
        if (Auth::user()->can('Create Allowance Option')) {
            $request->validate([
                'name' => 'required',
            ]);

            $allowanceoption = new AllowanceOption();
            $allowanceoption->name = $request->name;
            $allowanceoption->save();

            return redirect()
                ->route('allowance-option.index')
                ->with('success', __('Document type successfully created.'));
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
        if (Auth::user()->can('Edit Allowance Option')) {
            $allowanceoption = AllowanceOption::find($id);
            return response()->json($allowanceoption);
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
        if (Auth::user()->can('Edit Allowance Option')) {
            $request->validate([
                'name_update' => 'required',
            ]);

            $allowanceoption = AllowanceOption::find($id);
            $allowanceoption->name = $request->name_update;
            $allowanceoption->save();

            return redirect()
                ->route('allowance-option.index')
                ->with('success', __('Document type successfully updated.'));
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
        if (Auth::user()->can('Delete Allowance Option')) {
            $allowanceoption = AllowanceOption::findOrFail($id);
            $allowanceoption->delete();

            return redirect()
                ->route('allowance-option.index')
                ->with('success', __('Department successfully deleted.'));
        } else {
            return redirect()
                ->back()
                ->with('error', __('Permission denied.'));
        }
    }

    public function loadDatatable(AllowanceOptionDataTable $datatable)
    {
        return $datatable->ajax();
    }
}
