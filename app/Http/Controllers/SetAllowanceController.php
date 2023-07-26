<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Allowance;
use Illuminate\Http\Request;
use App\Models\AllowanceOption;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\SetAllowanceRequest;

class SetAllowanceController extends Controller
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
     * @return \Illuminate\Contracts\View\View
     */
    public function create($employee)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SetAllowanceRequest $request)
    {
        if (Auth::user()->can('Create Set Salary')) {
            Allowance::create([
                'employee_id' => $request->employee,
                'allowance_option_id' => $request->allowance_type,
                'title' => $request->title,
                'amount' => $request->amount,
                'type' => $request->type
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
    public function show(Allowance $allowance)
    {
        return response()->json($allowance);
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
    public function update(SetAllowanceRequest $request, Allowance $allowance)
    {
        if (Auth::user()->can('Create Set Salary')) {
            $allowance->allowance_option_id = $request->allowance_type;
            $allowance->title = $request->title;
            $allowance->amount = $request->amount;
            $allowance->type = $request->type;

            if ($allowance->isDirty()) {
                $allowance->save();
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
    public function destroy(Allowance $allowance)
    {
        if (Auth::user()->can('Create Set Salary')) {
            $allowance->delete();

            return response(200);
        } else {
            abort(401);
        }
    }
}
