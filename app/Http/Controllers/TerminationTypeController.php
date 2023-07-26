<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TerminationType;
use Illuminate\Support\Facades\Auth;
use App\DataTables\TerminationTypeDataTable;

class TerminationTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->can('Manage Termination Type')) {
            return view('terminationtype.index');
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
        if (Auth::user()->can('Create Termination Type')) {
            return view('terminationtype.create');
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
        if (Auth::user()->can('Create Termination Type')) {
            $request->validate([
                'name' => 'required',
            ]);

            $terminationtype = new TerminationType();
            $terminationtype->name = $request->name;
            $terminationtype->save();

            return redirect()
                ->route('terminationtype.index')
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
        if (Auth::user()->can('Edit Termination Type')) {
            $terminationtype = TerminationType::find($id);
            return response()->json($terminationtype);
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
        if (Auth::user()->can('Edit Termination Type')) {
            $request->validate([
                'name_update' => 'required',
            ]);

            $terminationtype = TerminationType::find($id);
            $terminationtype->name = $request->name_update;
            $terminationtype->save();

            return redirect()
                ->route('terminationtype.index')
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
        if (Auth::user()->can('Delete Termination Type')) {
            $terminationtype = TerminationType::findOrFail($id);
            $terminationtype->delete();

            return redirect()
                ->route('terminationtype.index')
                ->with('success', __('Department successfully deleted.'));
        } else {
            return redirect()
                ->back()
                ->with('error', __('Permission denied.'));
        }
    }

    public function loadDatatable(TerminationTypeDataTable $datatable)
    {
        return $datatable->ajax();
    }
}
