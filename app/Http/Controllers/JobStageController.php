<?php

namespace App\Http\Controllers;

use App\Models\JobStage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobStageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->can('Manage Job Stage')) {
            $jobstages = JobStage::all();

            return view('jobstage.index', compact('jobstages'));
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
        if (Auth::user()->can('Create Job Stage')) {
            return view('jobstage.create');
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
        if (Auth::user()->can('Create Job Stage')) {
            $request->validate(
                [
                    'name' => 'required',
                ],
                [
                    'name.required' => 'Name is required',
                ],
            );

            $jobstage = new JobStage();
            $jobstage->name = $request->name;
            $jobstage->save();

            return redirect()
                ->route('jobstage.index')
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
        if (Auth::user()->can('Edit Job Stage')) {
            $jobstage = JobStage::find($id);
            return view('jobstage.edit', compact('jobstage'));
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
        if (Auth::user()->can('Edit Job Stage')) {
            $request->validate(
                [
                    'name' => 'required',
                ],
                [
                    'name.required' => 'Name is required',
                ],
            );

            $jobstage = JobStage::find($id);
            $jobstage->name = $request->name;
            $jobstage->save();

            return redirect()
                ->route('jobstage.index')
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
        if (Auth::user()->can('Delete Job Stage')) {
            $jobstage = JobStage::findOrFail($id);
            $jobstage->delete();

            return redirect()
                ->route('jobstage.index')
                ->with('success', __('Department successfully deleted.'));
        } else {
            return redirect()
                ->back()
                ->with('error', __('Permission denied.'));
        }
    }

    public function order(Request $request)
    {
        $post = $request->all();
        foreach($post['order'] as $key => $item)
        {
            $stage        = JobStage::where('id', '=', $item)->first();
            $stage->order = $key;
            $stage->save();
        }
    }
}
