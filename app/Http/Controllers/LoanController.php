<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Employee;
use App\Models\LoanType;
use Illuminate\Http\Request;
use App\DataTables\LoanDataTable;
use App\Http\Requests\LoanRequest;
use Illuminate\Support\Facades\Auth;

class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        if (Auth::user()->can('Manage Loan') || Auth::user()->can('Show Loan')) {
            $employees = Employee::with('user')->get();
            $loan_types = LoanType::get();
            return view('loan.index', compact(['employees', 'loan_types']));
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
    public function store(LoanRequest $request)
    {
        if (Auth::user()->can('Create Loan')) {
            Loan::create([
                'employee_id' => $request->employee,
                'loan_type_id' => $request->loan_type,
                'amount' => $request->loan_amount,
                'payable_amount' => $request->payable_amount,
                'installment_month' => $request->installment_month,
                'installment_amount' => ($request->payable_amount / $request->installment_month),
                'activation_date' => $request->activation_date,
                'reason' => $request->reason,
                'reference_by' => $request->reference_by
            ]);

            return response(201);
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

    /**
     * Summary of data
     * @param LoanDataTable $loanDataTable
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(LoanDataTable $loanDataTable)
    {
        return $loanDataTable->ajax();
    }
}
