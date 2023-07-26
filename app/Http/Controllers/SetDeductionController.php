<?php

namespace App\Http\Controllers;

use App\Models\Deduction;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\DeductionRequest;

class SetDeductionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(DeductionRequest $request)
    {
        if (Auth::user()->can('Create Set Salary')) {
            Deduction::create([
                'employee_id' => $request->employee,
                'title' => $request->deduction_title,
                'amount' => $request->deduction_amount,
                'type' => $request->deduction_type,
                'recurring' => $request->deduction_recurring,
                'compliance' => $request->deduction_compliance ?? 0,
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Deduction $deduction)
    {
        if (Auth::user()->can('Create Set Salary')) {
            return response()->json($deduction);
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
    public function update(DeductionRequest $request, Deduction $deduction)
    {
        if (Auth::user()->can('Create Set Salary')) {
            $deduction->title = $request->deduction_title;
            $deduction->amount = $request->deduction_amount;
            $deduction->type = $request->deduction_type;
            $deduction->recurring = $request->deduction_recurring;

            if ($deduction->isDirty()) {
                $deduction->save();
            }

            return response(200);
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
    public function destroy(Deduction $deduction)
    {
        if (Auth::user()->can('Create Set Salary')) {
            $deduction->delete();

            return response(200);
        } else {
            abort(401);
        }
    }
}
