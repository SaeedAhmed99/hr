<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use App\Models\Holiday;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function futureNotice()
    {
        $notice_data = [];
        if (auth()->user()->employee) {
            $notices = Notice::where('employee_id', auth()->user()->employee->id)->where('notice_date', ">=", now()->format("Y-m-d"))->get();
            foreach ($notices as $notice) {
                $notice_data[] = [
                    'title' => $notice->type . ": " . $notice->title,
                    'start' => $notice->notice_date . " " . $notice->notice_time,
                    'description' => $notice->description,
                    'className' => 'pointer'
                ];
            }
        }

        $holidays = Holiday::where('holidate', '>=', now()->format("Y-m-d"))->get();
        foreach ($holidays as $holiday) {
            $notice_data[] = [
                'title' => $holiday->name,
                'start' => $holiday->holidate,
                'end' => $holiday->end_date,
                'color' => 'rgb(115 134 213)',
                'className' => 'pointer'
            ];
        }

        return response()->json($notice_data);
    }
}
