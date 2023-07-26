<?php

namespace App\Http\Controllers;

use App\DataTables\PerformanceCriteriaDataTable;
use App\Models\PerformanceCriterion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PerformanceCriterionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        if(Auth::user()->can("Manage Performance Criterion")){
            return view('performancecriterion.index');
        }else{
            abort(401);
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
        $request->validate([
            'name' => 'required'
        ]);

        PerformanceCriterion::create([
            'name' => $request->name
        ]);

        return response("Performance Criterion Created Successfully", 201);
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
        if (Auth::user()->can('Edit Performance Criterion')) {
            $performanceCriterion = PerformanceCriterion::find($id);

            return response()->json($performanceCriterion);
        } else {
            abort(401);
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
       if (Auth::user()->can('Edit Performance Criterion')) {
            $request->validate([
                'name_update' => 'required',
            ]);
            $performanceCriterion = PerformanceCriterion::find($id);
            //dd($request);
            $performanceCriterion->name = $request->name_update;
            $performanceCriterion->save();

           return response("Performance Criterion Updated Successfully", 200);
        }  else {
            abort(401);
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
        if (Auth::user()->can('Delete Performance Criterion')) {
            $performanceCriterion = PerformanceCriterion::findOrFail($id);
            $performanceCriterion->delete();
            return response("Performance Criterion Deleted Successfully", 200);
        } else {
            abort(401);

        }
    }

    /**
     * Summary of data
     * @param PerformanceCriteriaDataTable $performanceCriteriaDataTable
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(PerformanceCriteriaDataTable $performanceCriteriaDataTable)
    {
        if (Auth::user()->can("Manage Performance Criterion")) {
            return $performanceCriteriaDataTable->ajax();
        } else {
            abort(401);
        }
    }
}
