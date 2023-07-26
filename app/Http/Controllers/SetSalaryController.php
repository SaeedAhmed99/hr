<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Allowance;
use Illuminate\Http\Request;
use App\Models\AllowanceOption;
use App\DataTables\SalaryDataTable;
use Illuminate\Support\Facades\Auth;
use App\DataTables\AllowanceDataTable;

class SetSalaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        if (Auth::user()->can('Manage Set Salary')) {
            return view('setsalary.index');
        } else {
            abort(401);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create($employee)
    {
        if (Auth::user()->can('Create Set Salary')) {
            $employee = Employee::findOrFail($employee);
            $allowance_options = AllowanceOption::get();
            return view('setsalary.create', compact('employee', 'allowance_options'));
        } else {
            abort(401);
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
        //
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

    public function data(SalaryDataTable $salaryDataTable)
    {
        return $salaryDataTable->ajax();
    }
}
