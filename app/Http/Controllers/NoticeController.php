<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use Illuminate\Http\Request;
use App\DataTables\NoticeDataTable;

class NoticeController extends Controller
{
    public function data(NoticeDataTable $noticeDataTable)
    {
        return $noticeDataTable->ajax();
    }

    public function update(Notice $notice)
    {
        if($notice->employee_id != auth()->user()->employee->id){
            abort(401, "Unauthorized action!");
        }

        $notice->seen = 1;
        $notice->save();

        return response('Successfully marked!', 200);
    }

    public function clearAll()
    {
        Notice::where('employee_id', auth()->user()->employee->id)->update([
            'seen' => 1
        ]);

        return response("Success!", 200);
    }
}
