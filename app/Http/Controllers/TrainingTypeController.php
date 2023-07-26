<?php

namespace App\Http\Controllers;

use App\Models\TrainingType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\DataTables\TrainingTypeDataTable;

class TrainingTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->can('Manage Training Type')) {
            $trainingtypes = TrainingType::all();

            return view('trainingtype.index', compact('trainingtypes'));
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
        if (Auth::user()->can('Create Training Type')) {
            return view('trainingtype.create');
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
        if (Auth::user()->can('Create Training Type')) {
            $request->validate(
                [
                    'name' => 'required',
                ],
                [
                    'name.required' => 'Name is required',
                ],
            );

            $trainingtype = new TrainingType();
            $trainingtype->name = $request->name;
            $trainingtype->save();

            return redirect()
                ->route('trainingtype.index')
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
        if (Auth::user()->can('Edit Training Type')) {
            $trainingtype = TrainingType::find($id);
            return response()->json($trainingtype);
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
        if (Auth::user()->can('Edit Training Type')) {
            $request->validate([
                'name_update' => 'required',
            ]);

            $trainingtype = TrainingType::find($id);
            $trainingtype->name = $request->name_update;
            $trainingtype->save();

            return redirect()
                ->route('trainingtype.index')
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
        if (Auth::user()->can('Delete Training Type')) {
            $trainingtype = TrainingType::findOrFail($id);
            $trainingtype->delete();

            return redirect()
                ->route('trainingtype.index')
                ->with('success', __('Department successfully deleted.'));
        } else {
            return redirect()
                ->back()
                ->with('error', __('Permission denied.'));
        }
    }

    public function loadDatatable(TrainingTypeDataTable $datatable)
    {
        return $datatable->ajax();
    }
}
