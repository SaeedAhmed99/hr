<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\SalarySlip;
use Illuminate\Http\Request;
use App\Models\LoanPaymentInfo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\DataTables\SalarySlipDataTable;

class MonthlySalaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        if (Auth::user()->can('Manage Generate Salary')) {
            $generated_salary_history = SalarySlip::select(DB::raw("count(*) as total_employee, SUM(total_earning) as sum_earning, salary_month, created_at"))->groupBy(DB::raw('MONTH(`salary_month`)'))->orderBy('salary_month', 'desc')->limit(13)->get();
            return view('monthlysalary.index', compact('generated_salary_history'));
        } else {
            abort(401);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Contracts\View\View
     */
    public function create(Request $request)
    {
        if (Auth::user()->can('Show Generate Salary')) {
            if (SalarySlip::where('salary_month', $request->year . "-" . sprintf("%02d", $request->month) . "-01")->count('id') > 0) {
                return response()->json(['message' => 'This months salary has been generated'], 406);
            }

            $employees = Employee::with('designation', 'user', 'allowances', 'commissions', 'deductions')->with('loans', function ($query) {
                $query->where('status', 0)->whereRaw('payable_amount > (paid_amount + 100)');
            })->where('date_of_joining', '<=', $request->year . "-" . sprintf("%02d", $request->month) . "-01")->where('status', 1)->get();

            $salaries = [];

            foreach ($employees as $employee) {
                $salaries[$employee->id] = [
                    'data' => $employee,
                    'basic' => $employee->salary,
                    'allowance' => $employee->allowances->sum(function ($value) use ($employee) {
                        if ($value['type'] == 0) {
                            return $value['amount'];
                        } else {
                            return ($employee->salary * $value['amount']) / 100;
                        }
                    }),
                    'commission' => $employee->commissions->sum(function ($value) use ($employee) {
                        if ($value['type'] == 0) {
                            return $value['amount'];
                        } else {
                            return ($employee->salary * $value['amount']) / 100;
                        }
                    }),
                    'deduction' => $employee->deductions->sum(function ($value) use ($employee) {
                        if ($value['type'] == 0) {
                            return $value['amount'];
                        } else {
                            return ($employee->salary * $value['amount']) / 100;
                        }
                    }),
                    'loan' => $employee->loans->sum(function ($value) use ($employee) {
                        if ($value['payable_amount'] >= $value['paid_amount']) {
                            return $value['installment_amount'];
                        }
                    }),
                ];
            }

            return view('monthlysalary.preview', compact('salaries'));
        } else {
            abort(401);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Auth::user()->can('Create Generate Salary')) {
            if (SalarySlip::where('salary_month', $request->year . "-" . sprintf("%02d", $request->month) . "-01")->count('id') > 0) {
                return response()->json(['message' => 'This months salary has been generated'], 406);
            }

            $employees = Employee::with('designation', 'user', 'allowances', 'commissions', 'deductions')->with('loans', function ($query) {
                $query->where('status', 0)->whereRaw('payable_amount > (paid_amount + 100)');
            })->where('status', 1)->get();

            $salaries = [];

            $commission_to_delete = [];
            $deduction_to_delete = [];

            foreach ($employees as $employee) {
                $allowance = $employee->allowances->sum(function ($value) use ($employee) {
                    if ($value['type'] == 0) {
                        return $value['amount'];
                    } else {
                        return ($employee->salary * $value['amount']) / 100;
                    }
                });

                $commission = $employee->commissions->sum(function ($value) use ($employee, $commission_to_delete) {
                    if ($value['type'] == 0) {
                        return $value['amount'];
                    } else {
                        return ($employee->salary * $value['amount']) / 100;
                    }
                    if ($value->recurring == 1) {
                        $commission_to_delete[] = $value->id;
                    }
                });

                $deduction = $employee->deductions->sum(function ($value) use ($employee, $deduction_to_delete) {
                    if ($value['type'] == 0) {
                        return $value['amount'];
                    } else {
                        return ($employee->salary * $value['amount']) / 100;
                    }
                    if ($value->recurring == 1) {
                        $deduction_to_delete[] = $value->id;
                    }
                });

                $loan = $employee->loans->sum(function ($value) use ($employee) {
                    if ($value['payable_amount'] >= $value['paid_amount']) {
                        return $value['installment_amount'];
                    }
                });
                $ney_payable = ($employee->salary + $allowance + $commission) - ($deduction + $loan);
                $salaries[] = [
                    'employee_id' => $employee->id,
                    'net_payable' => $ney_payable * 100,
                    'total_earning' => ($employee->salary + $allowance + $commission) * 100,
                    'salary_month' => $request->year . "-" . sprintf("%02d", $request->month) . "-01",
                    'status' => 1,
                    'basic_salary' => $employee->salary * 100,
                    'allowance' => $employee->allowances->toJson(),
                    'commission' => $employee->commissions->toJson(),
                    'deduction' => $employee->deductions->toJson(),
                    'loan' => $employee->loans->toJson(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            DB::transaction(function () use ($salaries, $employees, $request) {
                SalarySlip::insert($salaries);

                foreach ($employees as $employee) {
                    $salary_slip = $employee->salarySlip()->where('employee_id', $employee->id)->where('salary_month', $request->year . "-" . sprintf("%02d", $request->month) . "-01")->first();
                    foreach ($employee->loans as $loan) {
                        $loan->paid_amount += $loan->installment_amount;
                        $loan->paid_amount = round($loan->paid_amount);
                        if ($loan->paid_amount >= $loan->payable_amount) {
                            $loan->status = 1;
                            $loan->completed_at = now();
                        }
                        $loan->save();

                        LoanPaymentInfo::create([
                            'employee_id' => $employee->id,
                            'loan_id' => $loan->id,
                            'paid_month' => $request->year . "-" . sprintf("%02d", $request->month) . "-01",
                            'salary_slip_id' => $salary_slip->id,
                        ]);
                    }

                    foreach ($employee->commissions as $commission) {
                        if ($commission->recurring == 0) {
                            $commission->delete();
                        }
                    }

                    foreach ($employee->deductions as $deduction) {
                        if ($deduction->recurring == 0) {
                            $deduction->delete();
                        }
                    }
                }
            });


            return response(201);
        } else {
            abort(401);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show($paySlip)
    {
        $paySlip = SalarySlip::with('employee.user', 'employee.branch', 'employee.department', 'employee.designation')->findOrFail($paySlip);
        return view('monthlysalary.payslip', compact('paySlip'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function showGenerated(Request $request)
    {
        if (Auth::user()->can('Show Generate Salary') OR Auth::user()->can('Manage Generate Salary')) {
            if(isset($request->month)){
                $selected_month = $request->month;
            }else{
                $selected_month = now()->format('n');
            }
            return view('monthlysalary.show', compact('selected_month'));
        } else {
            abort(401);
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function data(SalarySlipDataTable $salarySlipDataTable, $year, $month)
    {
        if (Auth::user()->can('Show Generate Salary') OR Auth::user()->can('Manage Generate Salary')) {
            return $salarySlipDataTable->with('year', $year)->with('month', $month)->ajax();
        } else {
            abort(401);
        }
    }
}
