<?php

namespace App\Schedules;

use App\Models\Transfer;

class TransferEmployee
{
    public function __invoke()
    {
        $transfers = Transfer::with('employee')->where('transfer_date', now())->get();

        foreach ($transfers as $transfer) {
            $transfer->employee->branch_id = $transfer->new_branch_id;
            $transfer->employee->department_id = $transfer->new_department_id;
            $transfer->employee->save();
        }
    }
}
