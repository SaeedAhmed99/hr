<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use App\Models\Employee;
use App\Models\Termination;
use Illuminate\Http\Request;
use App\Models\TerminationType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\DataTables\TerminationDataTable;

class TerminationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->can('Manage Termination'))
        {
                $terminations = Termination::all();
                $employees= Employee::all();
                $termination_types= TerminationType::all();

            return view('termination.index', compact('terminations','employees','termination_types'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
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
        if (Auth::user()->can('Create Termination')) {
            $request->validate([
                'employee' => 'required',
                'termination_type' => 'required',
                'notice_date' => 'required',
                'termination_date' => 'required',
            ]);

            $termination = new Termination();
            $termination->employee_id = $request->employee;
            $termination->termination_type_id = $request->termination_type;
            $termination->notice_date = $request->notice_date;
            $termination->termination_date = $request->termination_date;
            $termination->description = $request->description;
            $termination->save();

            $termination_type = TerminationType::find($termination->termination_type_id);

            Notice::create([
                'type' => "Termination",
                'title' => $termination_type->name,
                'body' => $termination->description,
                'notice_date' => $termination->notice_date,
                'employee_id' => $termination->employee_id
            ]);

            return redirect()
                ->route('termination.index')
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
        if (Auth::user()->can('Edit Termination')) {
            $termination = Termination::find($id);
            return response()->json($termination);
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
        if (Auth::user()->can('Edit Termination')) {
            $request->validate([
                'employee_update' => 'required',
                'termination_type_update' => 'required',
                'notice_date_update' => 'required',
                'termination_date_update' => 'required',
            ]);

            $termination = Termination::find($id);
            $termination->employee_id = $request->employee_update;
            $termination->termination_type_id = $request->termination_type_update;
            $termination->notice_date = $request->notice_date_update;
            $termination->termination_date = $request->termination_date_update;
            $termination->description = $request->description_update;
            $termination->save();


            $request->session()->flash('success', __('Termination type successfully updated.'));
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
        if (Auth::user()->can('Delete Termination')) {
            $termination = Termination::findOrFail($id);
            $termination->delete();

            Session::flash('message', 'Category successfully updated!');
        } else {
            return redirect()
                ->back()
                ->with('error', __('Permission denied.'));
        }
    }

     public function loadDatatable(TerminationDataTable $datatable)
    {
        return $datatable->ajax();
    }
}
