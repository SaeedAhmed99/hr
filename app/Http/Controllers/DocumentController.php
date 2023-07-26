<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\DataTables\DocumentDataTable;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->can('Manage Document Type')) {
            $documents = Document::all();

            return view('document.index', compact('documents'));
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
        if (Auth::user()->can('Create Document Type')) {
            return view('document.create');
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
        if (Auth::user()->can('Create Document Type')) {
            $request->validate([
                'name' => 'required',
                'required' => 'required',
            ]);

            $document = new Document();
            $document->name = $request->name;
            $document->is_required = $request->required;
            $document->save();

            return redirect()
                ->route('document.index')
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
        if (Auth::user()->can('Edit Document Type')) {
            $document = Document::find($id);
            return response()->json($document);
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
        if (Auth::user()->can('Edit Document Type')) {
            $request->validate(
                [
                    'name_update' => 'required',
                    'required_update' => 'required',
                ]);

            $document = Document::find($id);
            $document->name = $request->name_update;
            $document->is_required = $request->required_update;
            $document->save();

            return redirect()
                ->route('document.index')
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
        if (Auth::user()->can('Delete Designation')) {
            $document = Document::findOrFail($id);
            $document->delete();

            return redirect()
                ->route('document.index')
                ->with('success', __('Department successfully deleted.'));
        } else {
            return redirect()
                ->back()
                ->with('error', __('Permission denied.'));
        }
    }
    public function loadDatatable(DocumentDataTable $datatable)
    {
        return $datatable->ajax();
    }
}
