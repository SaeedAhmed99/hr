<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\ImportEmployee;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    public function importView(Request $request)
    {
        return view('employee.import');
    }

    public function import(Request $request)
    {
        Excel::import(new ImportEmployee(), $request->file('file')->store('files'));
        return redirect()
            ->route('employee.index')
            ->with('success', __('Employee  successfully Imported.'));
    }
}
