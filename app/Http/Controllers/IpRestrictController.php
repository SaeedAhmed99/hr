<?php

namespace App\Http\Controllers;

use App\Models\IpRestrict;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\DataTables\IpRestrictDataTable;

class IpRestrictController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->can('Manage Ip')) {
            return view('ip_restrict.index');
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
        if (Auth::user()->can('Create Ip')) {
            $request->validate([
                'ip' => 'required',
            ]);

            $ip = new IpRestrict();
            $ip->ip = $request->ip;
            $ip->save();

            return response(201);
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
        if (Auth::user()->can('Edit Ip')) {
            $ip = IpRestrict::find($id);
            return response()->json($ip);
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
        if (Auth::user()->can('Edit Ip')) {
            $request->validate([
                'ip_update' => 'required',
            ]);

            $ip = IpRestrict::find($id);
            $ip->ip = $request->ip_update;
            $ip->save();

            return response(200);
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
        if (Auth::user()->can('Delete Ip')) {
            $ip = IpRestrict::find($id);
            $ip->delete();

            return response(200);
        } else {
            return response(401);
        }
    }

    public function loadDatatable(IpRestrictDataTable $datatable)
    {
        return $datatable->ajax();
    }
}
