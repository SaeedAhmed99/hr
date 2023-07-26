<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Trainer;
use App\Models\Employee;
use App\Models\Training;
use App\Models\TrainingType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\DataTables\TrainingDataTable;

class TrainingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->can('Manage Training') or Auth::user()->can('Show Training')) {
            $branches = Branch::all();
            $trainingTypes = TrainingType::all();
            $trainers = Trainer::all();
            $employees = Employee::with('user')->get();
            $options = Training::$options;
            return view('training.index',compact('branches', 'trainingTypes', 'trainers', 'employees', 'options'));
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
        if (Auth::user()->can('Create Training')) {
            $branches = Branch::all();
            $trainingTypes = TrainingType::all();
            $trainers = Trainer::all();
            $employees = Employee::with('user')->get();
            $options = Training::$options;
            //dd($options);

            return view('training.create', compact('branches', 'trainingTypes', 'trainers', 'employees', 'options'));
        } else {
            return redirect()
                ->back()
                ->with('error', __('Permission denied.'));
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
        if (Auth::user()->can('Create Training')) {
            $request->validate([
                'branch' => 'required',
                'training_type' => 'required',
                'trainer_option' => 'required',
                'training_cost' => 'required',
                'trainer' => 'required',
                'employee' => 'required',
                'start_date' => 'required',
                'end_date' => 'required',
            ]);

            $training = new Training();
            $training->branch_id = $request->branch;
            $training->trainer_option = $request->trainer_option;
            $training->training_type_id = $request->training_type;
            $training->trainer_id = $request->trainer;
            $training->training_cost = $request->training_cost;
            $training->employee_id = $request->employee;
            $training->start_date = $request->start_date;
            $training->end_date = $request->end_date;
            $training->description = $request->description;
            $training->save();

            return redirect()
                ->route('training.index')
                ->with('success', __('Training successfully created.'));
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
        //$traId       = Crypt::decrypt($id);
        $training    = Training::with('traningtype','employee')->find($id);
        //dd($training->employee->designation->name);
        $performances = Training::$performance;
        $allstatus      = Training::$Status;

        return view('training.show', compact('training', 'performances', 'allstatus'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Auth::user()->can('Edit Training')) {
            $training = Training::find($id);

            return response()->json($training);

            //return view('training.edit', compact('branches', 'trainingTypes', 'trainers', 'employees', 'options', 'training'));
        } else {
            return redirect()
                ->back()
                ->with('error', __('Permission denied.'));
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
        if (Auth::user()->can('Edit Training')) {
            $request->validate([
                'branch_update' => 'required',
                'trainer_option_update' => 'required',
                'trainer_update' => 'required',
                'training_cost_update' => 'required',
                'employee_update' => 'required',
                'start_date_update' => 'required',
                'end_date_update' => 'required',
            ]);
            $training = Training::find($id);
            //dd($request);
            $training->branch_id = $request->branch_update;
            $training->trainer_option = $request->trainer_option_update;
            $training->training_type_id = $request->training_type_update;
            $training->trainer_id = $request->trainer_update;
            $training->training_cost = $request->training_cost_update;
            $training->employee_id = $request->employee_update;
            $training->start_date = $request->start_date_update;
            $training->end_date = $request->end_date_update;
            $training->description = $request->description;
            $training->save();

            return redirect()
                ->route('training.index')
                ->with('success', __('Training successfully updated.'));
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
        if (Auth::user()->can('Delete Training')) {
            $training = Training::findOrFail($id);
            $training->delete();

            return redirect()
                ->route('training.index')
                ->with('success', __('Training successfully deleted.'));
        } else {
            return redirect()
                ->back()
                ->with('error', __('Permission denied.'));
        }
    }

    public function updateStatus(Request $request)
    {
        $training              = Training::find($request->id);
        //dd($training);
        $training->performance = $request->performance;
        $training->status      = $request->status;
        $training->remarks     = $request->remarks;
        $training->save();

        return redirect()->route('training.index')->with('success', __('Training status successfully updated.'));
    }

    public function loadDatatable(TrainingDataTable $datatable)
    {
        return $datatable->ajax();
    }
}
