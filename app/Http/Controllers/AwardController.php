<?php

namespace App\Http\Controllers;

use App\Models\Award;
use App\Models\Notice;
use App\Models\Employee;
use App\Models\AwardType;
use Illuminate\Http\Request;
use App\DataTables\AwardDataTable;
use Illuminate\Support\Facades\Auth;

class AwardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->can('Manage Award') or Auth::user()->can('Show Award')) {
            $employees = Employee::with('user')->get();
            $awartypes = AwardType::all();
            return view('award.index', compact('employees', 'awartypes'));
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
        if (Auth::user()->can('Create Award')) {
            $request->validate([
                'employee' => 'required',
                'awartype' => 'required',
                'date' => 'required',
                'gift' => 'required',
            ]);

            $award = new Award();
            $award->employee_id = $request->employee;
            $award->award_type_id = $request->awartype;
            $award->date = $request->date;
            $award->gift = $request->gift;
            $award->description = $request->description;
            $award->save();

            $award_type = AwardType::find($request->awartype);

            Notice::create([
                'type' => "Award",
                'title' => $award_type->name,
                'body' => $award->description,
                'notice_date' => $request->date,
                'employee_id' => $award->employee_id
            ]);

            return response('Award Created Successfully', 201);
        } else {
            return response(401);
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
        if (Auth::user()->can('Edit Award')) {
            $award = Award::find($id);
            return response()->json($award);
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
        if (Auth::user()->can('Edit Award')) {
            $request->validate([
                'employee_update' => 'required',
                'awartype_update' => 'required',
                'date_update' => 'required',
                'gift_update' => 'required',
            ]);

            $award = Award::find($id);
            $award->employee_id = $request->employee_update;
            $award->award_type_id = $request->awartype_update;
            $award->date = $request->date_update;
            $award->gift = $request->gift_update;
            $award->description = $request->description;
            $award->save();

            return response('Award Upadated Successfully', 200);
        } else {
            return response(401);
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
        if (Auth::user()->can('Delete Award')) {
            $award = Award::find($id);
            $award->delete();

            return response('Award Deleted Successfully', 200);
        } else {
            return response(401);
        }
    }

    public function loadDatatable(AwardDataTable $datatable)
    {
        return $datatable->ajax();
    }
}
