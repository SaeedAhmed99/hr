<?php

namespace App\Http\Controllers;

use App\Models\AwardType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\DataTables\AwardTypeDataTable;

class AwardTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->can('Manage Award Type')) {
            return view('awardtype.index');
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
        if (Auth::user()->can('Create Award Type')) {
            return view('awardtype.create');
        } else {
            return response()->json(['error' => __('Permission denied.')], 401);
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
        if (Auth::user()->can('Create Award Type')) {
            $request->validate([
                'name' => 'required',
            ]);

            $awardtype = new AwardType();
            $awardtype->name = $request->name;
            $awardtype->save();

            return redirect()
                ->route('awardtype.index')
                ->with('success', __('Document type successfully created.'));
        } else {
            return redirect()
                ->back()
                ->with('error', __('Permission denied.'));
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
        if (Auth::user()->can('Edit Award Type')) {
            $awardtype = AwardType::find($id);
            return response()->json($awardtype);
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
        if (Auth::user()->can('Edit Award Type')) {
            $request->validate([
                'name_update' => 'required',
            ]);

            $awardtype = AwardType::find($id);
            $awardtype->name = $request->name_update;
            $awardtype->save();

            return redirect()
                ->route('awardtype.index')
                ->with('success', __('Document type successfully updated.'));
        } else {
            return redirect()
                ->back()
                ->with('error', __('Permission denied.'));
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
        if (Auth::user()->can('Delete Award Type')) {
            $awardtype = AwardType::findOrFail($id);
            $awardtype->delete();

            return redirect()
                ->route('awardtype.index')
                ->with('success', __('Department successfully deleted.'));
        } else {
            return redirect()
                ->back()
                ->with('error', __('Permission denied.'));
        }
    }

    public function loadDatatable(AwardTypeDataTable $datatable)
    {
        return $datatable->ajax();
    }
}
