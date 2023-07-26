<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Notice;
use App\Models\Employee;
use App\Models\Designation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\EmployeePerformance;
use App\Models\PerformanceCriterion;
use Illuminate\Support\Facades\Auth;
use App\Models\EmployeePerformanceScore;
use App\DataTables\EmployeePerformanceDataTable;
use Symfony\Component\Console\Descriptor\Descriptor;

class EmployeePerformanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->can('Manage Performance') or Auth::user()->can('Show Performance')) {
            $branches = Branch::all();
            $employees = Employee::with('user')->get();
            $designations = Designation::all();
            $performance_critarias = PerformanceCriterion::with('metric')->get();
            //dd($employees);

            return view('performance.index', compact('branches', 'employees', 'designations', 'performance_critarias'));
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
        if (Auth::user()->can('Create Performance')) {
            $request->validate([
                'branch' => 'required',
                'employee' => 'required',
                'month' => 'required',
                'remark' => 'required',
            ]);

            $employee = Employee::where('id', '=', $request->employee)->first();
            $designation_id = $employee->designation_id;

            $performance = new EmployeePerformance();
            $performance->branch_id = $request->branch;
            $performance->employee_id = $request->employee;
            $performance->designation_id = $designation_id;
            $performance->performance_month = $request->month . '-01';
            $performance->remark = $request->remark;
            $performance->performed_by = Auth::user()->id;
            $performance->save();

            $sum = 0;
            foreach ($request->rating as $key => $metric) {
                $performance_score = new EmployeePerformanceScore();
                $performance_score->employee_performance_id = $performance->id;
                $performance_score->performance_metric_id = $key;
                $performance_score->score = $metric;
                $performance_score->save();
                $sum += $metric;
            }
            $total_metric = count($request->rating);
            $performance->score_avarage = round($sum / $total_metric, 1);
            $performance->save();

            //dd(round($sum/$total_metric,1));
            $performance_month = new Carbon($performance->performance_month);
            Notice::create([
                'type' => "Performance",
                'title' => "Your avarage performance of month " . $performance_month->format("F, Y") . " is: " . $performance->score_avarage,
                'body' => $performance->remark,
                'notice_date' => now(),
                'employee_id' => $performance->employee_id
            ]);

            return response('Performance Created Successfully', 201);
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
        if (Auth::user()->can('Show Performance')) {
            $performance = EmployeePerformance::with('branch','employee.user','performance_score')->find($id);
            return response()->json($performance);
        } else {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Auth::user()->can('Edit Performance')) {
            $performance = EmployeePerformance::with('performance_score')->find($id);
            return response()->json($performance);
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
        if (Auth::user()->can('Edit Performance')) {
            $request->validate([
                'month_update' => 'required',
                'remark_update' => 'required',
            ]);

            $performance = EmployeePerformance::find($id);
            $performance->performance_month = $request->month_update . '-01';
            $performance->remark = $request->remark_update;
            $performance->save();

            $sum = 0;
            foreach ($request->rating_update as $key => $metric) {
                $performance_score = EmployeePerformanceScore::where('employee_performance_id', $id)
                    ->where('performance_metric_id', $key)
                    ->first();
                $performance_score->score = $metric;
                $performance_score->save();
                $sum += $metric;
            }

            $total_metric = count($request->rating_update);
            $performance->score_avarage = round($sum / $total_metric, 1);
            $performance->save();

            return response('Performance Updated Successfully', 200);
        } else {
            return response(401);
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
        if (Auth::user()->can('Delete Performance')) {
            $performance = EmployeePerformance::find($id);
            $performance->delete();

            EmployeePerformanceScore::where('employee_performance_id', $id)->delete();

            return response('Performance Deleted Successfully', 200);
        } else {
            return response(401);
        }
    }

    public function loadDatatable(EmployeePerformanceDataTable $datatable)
    {
        return $datatable->ajax();
    }

    public function employeeJson(Request $request)
    {
        $employees = Employee::with('user')
            ->where('branch_id', $request->branch)
            ->get()
            ->toArray();
        //dd($employees);
        return response()->json($employees);
    }
}
