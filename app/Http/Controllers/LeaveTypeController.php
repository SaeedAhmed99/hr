<?php

namespace App\Http\Controllers;

use App\Models\LeaveType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\DataTables\LeaveTypeDataTable;

class LeaveTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->can('Manage Leave Type')) {
            $leavetypes = LeaveType::all();

            return view('leavetype.index', compact('leavetypes'));
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
        if (Auth::user()->can('Create Leave Type')) {
            return view('leavetype.create');
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
        if (Auth::user()->can('Create Leave Type')) {
            $request->validate([
                'name' => 'required',
                'days' => 'required',
            ]);

            $leavetype = new LeaveType();
            $leavetype->name = $request->name;
            $leavetype->days = $request->days;
            $leavetype->save();

            return redirect()
                ->route('leavetype.index')
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
        if (Auth::user()->can('Edit Leave Type')) {
            $leavetype = LeaveType::find($id);
           return response()->json($leavetype);
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
        if (Auth::user()->can('Edit Leave Type')) {
            $request->validate(
                [
                    'name_update' => 'required',
                    'days_update' => 'required',
                ]
            );

            $leavetype = LeaveType::find($id);
            $leavetype->name = $request->name_update;
            $leavetype->days = $request->days_update;
            $leavetype->save();

            return redirect()
                ->route('leavetype.index')
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
        if (Auth::user()->can('Delete Leave Type')) {
            $leavetype = LeaveType::findOrFail($id);
            $leavetype->delete();

            return redirect()
                ->route('leavetype.index')
                ->with('success', __('Department successfully deleted.'));
        } else {
            return redirect()
                ->back()
                ->with('error', __('Permission denied.'));
        }
    }

    public function loadDatatable(LeaveTypeDataTable $datatable)
    {
        return $datatable->ajax();
    }
}
