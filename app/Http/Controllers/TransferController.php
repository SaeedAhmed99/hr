<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Notice;
use App\Models\Employee;
use App\Models\Transfer;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\DataTables\TransferDataTable;
use Illuminate\Support\Facades\Session;

class TransferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->can('Manage Transfer') or Auth::user()->can('Show Transfer')) {
            $branches = Branch::all();
            $departments = Department::all();
            $employees = Employee::all();
            return view('transfer.index', compact('branches', 'departments', 'employees'));
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
        if (Auth::user()->can('Create Transfer')) {
            $request->validate([
                'employee' => 'required',
                'date' => 'required',
            ]);
            $employee = Employee::find($request->employee);

            $transfer = new Transfer();
            $transfer->employee_id = $request->employee;
            $transfer->old_branch_id = $employee->branch_id;
            $transfer->old_department_id = $employee->department_id;

            if (empty($request->branch) OR $employee->branch_id == $request->branch) {
                $transfer->new_branch_id = $employee->branch_id;
            } else {
                $employee->branch_id = $request->branch;
                $transfer->new_branch_id = $request->branch;
            }
            if (empty($request->department) OR $employee->department_id == $request->department) {
                $transfer->new_department_id = $employee->department_id;
            } else {
                $employee->department_id = $request->department;
                $transfer->new_department_id = $request->department;
            }

            $transfer->transfer_date = $request->date;
            $transfer->description = $request->description;
            $transfer->save();

            $branches = Branch::whereIn('id', [
                $transfer->new_branch_id,$transfer->old_branch_id
            ])->get();

            $departments = Department::whereIn('id', [
                $transfer->new_department_id,$transfer->old_department_id
            ])->get();

            $message = "Transferred from";

            if($transfer->old_branch_id != $transfer->new_branch_id){
                $message .= " " . $branches->firstWhere('id', $transfer->old_branch_id)->name . " branch to " .$branches->firstWhere('id', $transfer->new_branch_id)->name . " branch";
            }
            
            if($transfer->old_branch_id != $transfer->new_branch_id AND $transfer->old_department_id != $transfer->new_department_id){
                $message .= " and";
            }

            if($transfer->old_department_id != $transfer->new_department_id){
                $message .= " " . $departments->firstWhere('id', $transfer->old_department_id)->name . " department to " .$departments->firstWhere('id', $transfer->new_department_id)->name . " department";
            }

            Notice::create([
                'type' => "Transfer",
                'title' => $message,
                'body' => $transfer->description,
                'notice_date' => $transfer->transfer_date,
                'employee_id' => $employee->id
            ]);

            return redirect()
                ->route('transfer.index')
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
        if (Auth::user()->can('Edit Transfer')) {
            $transfer = Transfer::find($id);
            return response()->json($transfer);
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
        if (Auth::user()->can('Edit Transfer')) {
            $request->validate([
                'employee_update' => 'required',
                'branch_update' => 'required',
                'department_update' => 'required',
                'date_update' => 'required',
            ]);

            $transfer = Transfer::find($id);
            $transfer->employee_id = $request->employee_update;
            $transfer->new_branch_id = $request->branch_update;
            $transfer->new_department_id = $request->department_update;
            $transfer->transfer_date = $request->date_update;
            $transfer->description = $request->description_update;
            $transfer->save();

            Employee::where('id',$request->employee_update)->update([
                'branch_id'=>$request->branch_update,
                'department_id'=>$request->department_update,
            ]);

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
        if (Auth::user()->can('Delete Transfer')) {
            $transfer = Transfer::findOrFail($id);
            $transfer->delete();

            Session::flash('message', 'Category successfully updated!');
        } else {
            return redirect()
                ->back()
                ->with('error', __('Permission denied.'));
        }
    }

    public function loadDatatable(TransferDataTable $datatable)
    {
        return $datatable->ajax();
    }
}
