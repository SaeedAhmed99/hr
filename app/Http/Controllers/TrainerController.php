<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Trainer;
use Illuminate\Http\Request;
use App\DataTables\TrainerDataTable;
use Illuminate\Support\Facades\Auth;

class TrainerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->can('Manage Trainer')) {
            //$trainers = Trainer::with('branch')->get();
            $branches = Branch::all();
            return view('trainer.index',compact('branches'));
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
        if (Auth::user()->can('Create Trainer')) {
            $branches = Branch::all();

            return view('trainer.create', compact('branches'));
        } else {
            return redirect()
                ->back()
                ->with('error', __('Permission denied.'));
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
        if (Auth::user()->can('Create Trainer')) {
            $request->validate([
                'firstname' => 'required',
                'contact' => 'required',
                'email' => 'required|email',
            ]);

            $trainer = new Trainer();
            $trainer->firstname = $request->firstname;
            $trainer->contact = $request->contact;
            $trainer->email = $request->email;
            $trainer->address = $request->address;
            $trainer->expertise = $request->expertise;
            $trainer->save();

            return redirect()
                ->route('trainer.index')
                ->with('success', __('Trainer  successfully created.'));
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
        if (Auth::user()->can('Edit Trainer')) {
            $trainer = Trainer::find($id);

            return response()->json($trainer);
        } else {
            return redirect()
                ->back()
                ->with('error', __('Permission denied.'));
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
        if (Auth::user()->can('Edit Trainer')) {
            $request->validate([
                'firstname_update' => 'required',
                'contact_update' => 'required',
                'email_update' => 'required',
            ]);

            $trainer = Trainer::find($id);
            $trainer->firstname = $request->firstname_update;
            $trainer->contact = $request->contact_update;
            $trainer->email = $request->email_update;
            $trainer->address = $request->address_update;
            $trainer->expertise = $request->expertise_update;
            $trainer->save();

            return redirect()
                ->route('trainer.index')
                ->with('success', __('Trainer  successfully updated.'));
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
        if (Auth::user()->can('Delete Trainer')) {
            $trainer = Trainer::findOrFail($id);
            $trainer->delete();

            return redirect()
                ->route('trainer.index')
                ->with('success', __('Trainer successfully deleted.'));
        } else {
            return redirect()
                ->back()
                ->with('error', __('Permission denied.'));
        }
    }

     public function loadDatatable(TrainerDataTable $datatable)
    {
        return $datatable->ajax();
    }
}
