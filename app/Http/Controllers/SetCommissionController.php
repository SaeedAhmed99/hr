<?php

namespace App\Http\Controllers;

use App\Models\Commission;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CommissionRequest;

class SetCommissionController extends Controller
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
    public function store(CommissionRequest $request)
    {
        if (Auth::user()->can('Create Set Salary')) {
            Commission::create([
                'employee_id' => $request->employee,
                'title' => $request->commission_title,
                'amount' => $request->commission_amount,
                'type' => $request->commission_type,
                'recurring' => $request->commission_recurring,
                'compliance' => $request->commission_compliance ?? 0,
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
    public function show(Commission $commission)
    {
        if (Auth::user()->can('Create Set Salary')) {
            return response()->json($commission);
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
    public function update(CommissionRequest $request, Commission $commission)
    {
        if (Auth::user()->can('Create Set Salary')) {
            $commission->title = $request->commission_title;
            $commission->amount = $request->commission_amount;
            $commission->type = $request->commission_type;
            $commission->recurring = $request->commission_recurring;

            if ($commission->isDirty()) {
                $commission->save();
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
    public function destroy(Commission $commission)
    {
        if (Auth::user()->can('Create Set Salary')) {
            $commission->delete();

            return response(200);
        } else {
            abort(401);
        }
    }
}
