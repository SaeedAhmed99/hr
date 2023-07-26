<?php

namespace App\Http\Controllers;

use App\Models\Travel;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\DataTables\TravelDataTable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class TravelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->can('Manage Travel') or Auth::user()->can('Show Travel'))
        {
                $travels = Travel::all();
                $employees= Employee::all();


            return view('travel.index', compact('travels','employees'));
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
        if (Auth::user()->can('Create Travel')) {
            $request->validate([
                'employee' => 'required',
                'start_date' => 'required',
                'end_date' => 'required',
                'purpose_of_visit' => 'required',
                'place_of_visit' => 'required',
            ]);

            $travel = new Travel();
            $travel->employee_id = $request->employee;
            $travel->start_date = $request->start_date;
            $travel->end_date = $request->end_date;
            $travel->purpose_of_visit = $request->purpose_of_visit;
            $travel->place_of_visit = $request->place_of_visit;
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
        if (Auth::user()->can('Edit Travel')) {
            $travel = Travel::find($id);
            return response()->json($travel);
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
         if (Auth::user()->can('Edit Travel')) {
            $request->validate([
                'employee_update' => 'required',
                'start_date_update' => 'required',
                'end_date_update' => 'required',
                'purpose_of_visit_update' => 'required',
                'place_of_visit_update' => 'required',
            ]);

            $travel = Travel::find($id);
            $travel->employee_id = $request->employee_update;
            $travel->start_date = $request->start_date_update;
            $travel->end_date = $request->end_date_update;
            $travel->purpose_of_visit = $request->purpose_of_visit_update;
            $travel->place_of_visit = $request->place_of_visit_update;
            $travel->description = $request->description_update;
            $travel->save();

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
         if (Auth::user()->can('Delete Travel')) {
            $travel = Travel::findOrFail($id);
            $travel->delete();

            Session::flash('message', 'Category successfully updated!');
        } else {
            return redirect()
                ->back()
                ->with('error', __('Permission denied.'));
        }
    }

    public function loadDatatable(TravelDataTable $datatable)
    {
        return $datatable->ajax();
    }
}
