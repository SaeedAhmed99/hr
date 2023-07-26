<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Leave;
use App\Models\Employee;
use App\Models\LeaveType;
use Illuminate\Http\Request;
use App\DataTables\LeaveDataTable;
use Illuminate\Support\Facades\Auth;
use App\DataTables\EmployeeLeaveDataTable;
use DataTables;

class LeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->can('Manage Leave') or Auth::user()->can('Show Leave')) {
            //$leaves = Leave::all();
            // $leaves=Leave::with('leaveType')->get();
            // dd($leaves);
            // if (Auth::user()->hrm->type == 'employee') {
            //     $user = Auth::user();
            //     $employee = Employee::where('user_id', '=', $user->id)->first();
            //     $leaves = Leave::where('employee_id', '=', $employee->id)->get();
            // } else {
            //     $leaves = Leave::all();
            //     $employees = Employee::with('user')->get();
            //     $leavetypes = LeaveType::all();
            // }
            $employees = Employee::with('user')->get();
            $leavetypes = LeaveType::all();

            return view('leave.index', compact('employees', 'leavetypes'));
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
        if (Auth::user()->can('Create Leave')) {
            if (Auth::user()->getUserType()->hrm->type == 'employee') {
                $employees = Employee::where('user_id', '=', Auth::user()->id)->get();
            } else {
                $employees = Employee::all();
                //dd($employees);
            }
            $leavetypes = LeaveType::all();
            //$leavetypes_days = LeaveType::where('created_by', '=', \Auth::user()->creatorId())->get();

            return view('leave.create', compact('employees', 'leavetypes'));
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
        if (Auth::user()->can('Create Leave') or Auth::user()->can('Show Leave')) {
            $request->validate([
                'leave_type_id' => 'required',
                'start_date' => 'required',
                'end_date' => 'required',
                'leave_reason' => 'required',
            ]);

            $employee = Employee::where('user_id', '=', Auth::user()->id)->first();
            $leave = new Leave();
            if (Auth::user()->can('Manage Leave')) {
                $leave->employee_id = $request->employee;
            } else {
                $leave->employee_id = $employee->id;
            }
            $leave->leave_type_id = $request->leave_type_id;
            $leave->applied_on = date('Y-m-d');
            $leave->start_date = $request->start_date;
            $leave->end_date = $request->end_date;

            if ($request->start_date == $request->end_date) {
                $leave->total_leave_days = 1;
            } else {
                $startDate = new \DateTime($request->start_date);
                $endDate = new \DateTime($request->end_date);
                $total_leave_days = !empty($startDate->diff($endDate)) ? $startDate->diff($endDate)->days : 0;

                $leave->total_leave_days = $total_leave_days;
            }

            $leave->leave_reason = $request->leave_reason;
            $leave->remark = $request->remark;
            $leave->status = 0;
            //dd($leave);
            $leave->save();

            return redirect()
                ->route('leave.index')
                ->with('success', __('Leave  successfully created.'));
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
        if (Auth::user()->can('Edit Leave')) {
            //$leave = Leave::with('employee.user')->find($id);
            // $employees = User::with('employee')->find($leave->);
            //$leavetypes = LeaveType::all();
            $leave = Leave::with('employee.user', 'leave_type')->find($id);
            return response()->json($leave);

            //return view('leave.edit', compact('leave', 'leavetypes'));
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
        $leave = Leave::find($id);
        if (Auth::user()->can('Edit Leave')) {
            $request->validate([
                'leave_type_id_update' => 'required',
                'start_date_update' => 'required',
                'end_date_update' => 'required',
                'leave_reason_update' => 'required',
            ]);

            $leave->employee_id = $request->employee_update;
            $leave->leave_type_id = $request->leave_type_id_update;
            $leave->start_date = $request->start_date_update;
            $leave->end_date = $request->end_date_update;

            $startDate = new \DateTime($request->start_date_update);
            $endDate = new \DateTime($request->end_date_update);
            $total_leave_days = !empty($startDate->diff($endDate)) ? $startDate->diff($endDate)->days : 0;

            $leave->total_leave_days = $total_leave_days;
            $leave->leave_reason = $request->leave_reason_update;
            $leave->remark = $request->remark;

            $leave->save();

            return redirect()
                ->route('leave.index')
                ->with('success', __('Leave successfully updated.'));
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
        if (Auth::user()->can('Delete Leave')) {
            $leave = Leave::findOrFail($id);
            $leave->delete();

            return redirect()
                ->route('leave.index')
                ->with('success', __('Leave successfully deleted.'));
        } else {
            return redirect()
                ->back()
                ->with('error', __('Permission denied.'));
        }
    }

    public function action($id)
    {
        $leave = Leave::with('employee.user', 'leave_type')->find($id);
        return response()->json($leave);
    }

    public function changeaction(Request $request)
    {
        $leave = Leave::find($request->leave_id);

        $leave->status = $request->status;
        if ($leave->status == 'Approved') {
            $startDate = new \DateTime($leave->start_date);
            $endDate = new \DateTime($leave->end_date);
            $total_leave_days = $startDate->diff($endDate)->days;
            $leave->total_leave_days = $total_leave_days;
            $leave->status = 1;
        } else {
            $startDate = new \DateTime($leave->start_date);
            $endDate = new \DateTime($leave->end_date);
            $total_leave_days = $startDate->diff($endDate)->days;
            $leave->total_leave_days = $total_leave_days;
            $leave->status = 2;
        }

        $leave->save();

        return redirect()
            ->route('leave.index')
            ->with('success', __('Leave status successfully updated.'));
    }

    public function loadDatatable(Request $request)
    {
        $from = date($request->from);
        $to = date($request->to);

        if ($from != '' && $to != '') {
            if (Auth::user()->can('Manage Leave')) {
                $query = Leave::with('employee.user', 'leave_type')->whereBetween('created_at', [$from . " 00:00:00", $to . " 23:59:59"])->get();
            } elseif (Auth::user()->can('Show Leave')) {
                $query = Leave::with('employee.user', 'leave_type')->where('leaves.employee_id', Auth::user()->employee->id)->select('leaves.*')->get();
            } else {
            }
        } else {
            if (Auth::user()->can('Manage Leave')) {
                $query = Leave::with('employee.user', 'leave_type')->select('leaves.*')->get();
            } elseif (Auth::user()->can('Show Leave')) {
                $query = Leave::with('employee.user', 'leave_type')->where('leaves.employee_id', Auth::user()->employee->id)->select('leaves.*')->get();
            } else {
            }
        }

        return Datatables::of($query)
            // ->eloquent()
            ->addColumn('employee', function ($query) {
                if (Auth::user()->hrm->type == 'company') {
                    return $query->employee ? $query->employee->user->name : '-';
                } else {
                    return '';
                }
            })
            ->addColumn('leave_type.name', function ($query) {
                return $query->leave_type ? $query->leave_type->name : '-';
            })
            ->addColumn('status', function ($query) {
                if ($query->status == 0) {
                    return '<span class="badge bg-warning p-2 px-3 rounded">Pending</span>';
                } elseif ($query->status == 1) {
                    return '<span class="badge bg-success p-2 px-3 rounded">Approved</span>';
                } elseif ($query->status == 2) {
                    return '<span class="badge bg-danger p-2 px-3 rounded">Reject</span>';
                }
            })
            ->addColumn('action', function ($query) {
                $button = '';
                if (Auth::user()->can('Manage Leave')) {
                    $button .= '<button data-bs-toggle="modal" data-bs-target="#action_leave_modal" data-id="' . $query->id . '" class="m-1 btn btn-primary btn-sm leave-action"><span class="btn-inner--icon"><i class="fa-solid fa-eye"></i></span></button>';
                }
                if (Auth::user()->can('Edit Leave')) {
                    $button .= '<button data-bs-toggle="modal" data-bs-target="#edit_leave_modal" data-id="' . $query->id . '" class="m-1 btn btn-primary btn-sm leave-edit"><span class="btn-inner--icon"><i class="fa-regular fa-pen-to-square"></i></span></button>';
                }
                if (Auth::user()->can('Delete Leave')) {
                    $button .= '<button data-id="' . $query->id . '" class="m-1 btn btn-danger btn-sm leave-delete"><span class="btn-inner--icon"><i class="fa-solid fa-trash"></i></span></i></button>';
                }
                return $button;
            })
            //    ->addColumn('action', function ($query) {
            //         return '
            //         <button data-bs-toggle="modal" data-bs-target="#action_leave_modal" data-id="'.$query->id.'" class="btn btn-primary btn-sm leave-action"><i class="fa-regular fa-pen-to-square"></i> Action</button>
            //         <button data-bs-toggle="modal" data-bs-target="#edit_leave_modal" data-id="'.$query->id.'" class="btn btn-primary btn-sm leave-edit"><span class="btn-inner--icon"><i class="fa-regular fa-pen-to-square"></i></span></button>
            //         <button data-id="'.$query->id.'" class="btn btn-danger btn-sm leave-delete"><span class="btn-inner--icon"><i class="fa-solid fa-trash"></i></span></i></button>';
            //     })
            ->rawColumns(['employee', 'status', 'action'])
            ->make(true);
        // return $datatable->with(['from' => $request->from, 'to' => $request->to])->ajax();

        if (Auth::user()->can('Manage Leave') or Auth::user()->can('Show Leave')) {
            //$leaves = Leave::all();
            // $leaves=Leave::with('leaveType')->get();
            // dd($leaves);
            // if (Auth::user()->hrm->type == 'employee') {
            //     $user = Auth::user();
            //     $employee = Employee::where('user_id', '=', $user->id)->first();
            //     $leaves = Leave::where('employee_id', '=', $employee->id)->get();
            // } else {
            //     $leaves = Leave::all();
            //     $employees = Employee::with('user')->get();
            //     $leavetypes = LeaveType::all();
            // }
            $employees = Employee::with('user')->get();
            $leavetypes = LeaveType::all();

            return view('leave.index', compact('employees', 'leavetypes'));
        } else {
            return redirect()
                ->back()
                ->with('error', __('Permission denied.'));
        }
    }

    public function leaveReportDatatable(EmployeeLeaveDataTable $datatable, Request $request)
    {
        return $datatable->with('year', $request->year)->ajax();
    }

    public function employeeLeaveReport()
    {
        return view('leave.employee-leave-report');
    }
}
