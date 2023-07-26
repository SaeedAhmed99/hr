<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\DataTables\AllowanceDataTable;
use App\DataTables\DeductionDataTable;
use App\DataTables\CommissionDataTable;

class PayrollDatatableController extends Controller
{
    /**
     * Summary of Allowance
     * @param AllowanceDataTable $datatable
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function employeeAllowance(AllowanceDataTable $datatable, $employee)
    {
        if (Auth::user()->can('Create Set Salary')) {
            return $datatable->with('employee_id', $employee)->ajax();
        } else {
            abort(401);
        }
    }

    /**
     * Summary of Employee Comission
     * @param CommissionDataTable $datatable
     * @param mixed $employee
     * @return \Illuminate\Http\JsonResponse
     */
    public function employeeCommission(CommissionDataTable $datatable, $employee)
    {
        if (Auth::user()->can('Create Set Salary')) {
            return $datatable->with('employee_id', $employee)->ajax();
        } else {
            abort(401);
        }
    }

    public function employeeDeduction(DeductionDataTable $datatable, $employee)
    {
        if (Auth::user()->can('Create Set Salary')) {
            return $datatable->with('employee_id', $employee)->ajax();
        } else {
            abort(401);
        }
    }
}
