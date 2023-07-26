<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\DataTables\PerformanceMetricDataTable;
use App\Models\PerformanceCriterion;
use App\Models\PerformanceMetric;

class PerformanceMetricController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->can('Manage Performance Metric')) {
            $performanceCriterions = PerformanceCriterion::all();
            return view('performancemetric.index', compact('performanceCriterions'));
        } else {
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
        if (Auth::user()->can('Create Performance Metric')) {
            $request->validate([
                'name' => 'required',
                'performanceCriterion' => 'required',
            ]);

            $performanceMetric = new PerformanceMetric();
            $performanceMetric->performance_criterion_id = $request->performanceCriterion;
            $performanceMetric->name = $request->name;
            $performanceMetric->save();

            return response('Performance Metric Created Successfully', 201);
        } else {
            abort(401);
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
        if (Auth::user()->can('Edit Performance Metric')) {
            $performanceMetric = PerformanceMetric::find($id);
            return response()->json($performanceMetric);
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
        if (Auth::user()->can('Edit Performance Metric')) {
            $request->validate([
                'performanceCriterion_update' => 'required',
                'name_update' => 'required',
            ]);
            $performanceMetric = PerformanceMetric::findOrFail($id);
            $performanceMetric->performance_criterion_id = $request->performanceCriterion_update;
            $performanceMetric->name = $request->name_update;
            $performanceMetric->save();

            return response('Performance Metric Updated Successfully', 200);
        } else {
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
        if(Auth::user()->can('Delete Department'))
        {
            $performanceMetric = PerformanceMetric::findOrFail($id);
            $performanceMetric->delete();

            return response('Performance Metric Deleted Successfully', 200);
        }
        else
        {
            abort(401);
        }
    }

    public function loadDatatable(PerformanceMetricDataTable $datatable)
    {
        return $datatable->ajax();
    }
}
