<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Hrm;
use App\Models\Employee;
use App\Models\Resignation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\DataTables\ResignationDataTable;

class ResignationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->can('Manage Resignation') or Auth::user()->can('Show Resignation')) {
            $resignations = Resignation::all();
            $employees = Employee::all();

            return view('resignation.index', compact('resignations', 'employees'));
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
        if (Auth::user()->can('Create Resignation')) {
            $request->validate([
                'employee' => 'required',
                'notice_date' => 'required',
                'resignation_date' => 'required',
            ]);

            $travel = new Resignation();
            $travel->employee_id = $request->employee;
            $travel->notice_date = $request->notice_date;
            $travel->resignation_date = $request->resignation_date;
            $travel->description = $request->description;
            $travel->save();

            return redirect()
                ->route('travel.index')
                ->with('success', __('Transfer successfully created.'));
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
        if (Auth::user()->can('Edit Resignation')) {
            $resignation = Resignation::find($id);
            return response()->json($resignation);
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
        if (Auth::user()->can('Edit Resignation')) {
            $request->validate([
                'employee_update' => 'required',
                'notice_date_update' => 'required',
                'resignation_date_update' => 'required',
            ]);

            $resignation = Resignation::find($id);
            $resignation->employee_id = $request->employee_update;
            $resignation->notice_date = $request->notice_date_update;
            $resignation->resignation_date = $request->resignation_date_update;
            $resignation->description = $request->description_update;
            $resignation->save();

            return redirect()
                ->route('travel.index')
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
        if (Auth::user()->can('Delete Resignation')) {
            $resignation = Resignation::findOrFail($id);
            $resignation->delete();

            Session::flash('message', 'Category successfully updated!');
        } else {
            return redirect()
                ->back()
                ->with('error', __('Permission denied.'));
        }
    }

    public function loadDatatable(ResignationDataTable $datatable)
    {
        return $datatable->ajax();
    }
}
