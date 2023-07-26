<?php

namespace App\Schedules;

use App\Models\Resignation;
use Carbon\Carbon;

class ResignationEmployeeStatus
{
    public function __invoke()
    {
        $resignations = Resignation::with([
            'employee.user.hrm' => function ($query) {
                $query->where('type', '=', 'employee')->where('active_status', 1);
            },
        ])->get();

        $today = now();
        $today->sub('1D');

        foreach ($resignations as $resignation) {
            if ($resignation->resignation_date == $today->format('Y-m-d')) {
                if ($resignation->employee->user->hrm and $resignation->employee->user->hrm->active_status == 1) {
                    $resignation->employee->user->hrm->active_status = 0;
                    $resignation->employee->user->status=0;
                    $resignation->employee->user->hrm->save();
                    $resignation->employee->user->save();
                }
            } else {
            }
        }
    }
}
