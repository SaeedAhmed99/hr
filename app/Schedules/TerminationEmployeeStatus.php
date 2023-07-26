<?php

namespace App\Schedules;

use App\Models\Termination;
use Carbon\Carbon;

class TerminationEmployeeStatus
{
    public function __invoke()
    {
        $terminations = Termination::with([
            'employee.user.hrm' => function ($query) {
                $query->where('type', '=', 'employee')->where('active_status', 1);
            },
        ])->get();

        $today = now();
        $today->sub('1D');

        foreach ($terminations as $termination) {
            if ($termination->termination_date == $today->format('Y-m-d')) {
                if ($termination->employee->user->hrm and $termination->employee->user->hrm->active_status == 1) {
                    $termination->employee->user->hrm->active_status = 0;
                    $termination->employee->user->status=0;
                    $termination->employee->user->hrm->save();
                    $termination->employee->user->save();
                }
            } else {
            }
        }
    }
}
