<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\DataTables\LoanTypeDataTable;
use App\Http\Requests\LoanTypeRequest;
use App\Models\LoanType;

class LoanTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        if (Auth::user()->can("Manage Loan Type")) {
            return view('loantype.index');
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
    public function store(LoanTypeRequest $request)
    {
        if (Auth::user()->can("Create Loan Type")) {
            LoanType::create($request->validated());
            return response("Created", 201);
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(LoanType $loanType)
    {
        if (Auth::user()->can("Update Loan Type")) {
            return response()->json($loanType);
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
    public function update(LoanTypeRequest $request, LoanType $loanType)
    {
        if (Auth::user()->can("Update Loan Type")) {
            $loanType->name = $request->name;
            $loanType->save();

            return response('Loan type updated succesfully!', 200);
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
    public function destroy(LoanType $loanType)
    {
        if (Auth::user()->can("Delete Loan Type")) {
            $loanType->delete();

            return response("Successfully deleted loan type!", 200);
        } else {
            abort(401);
        }
    }

    /**
     * Summary of data
     * @param LoanTypeDataTable $LoanTypeDataTable
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(LoanTypeDataTable $loanTypeDataTable)
    {
        if (Auth::user()->can("Manage Loan Type")) {
            return $loanTypeDataTable->ajax();
        } else {
            abort(401);
        }
    }
}
