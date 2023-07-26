<?php

namespace App\Schedules;

use App\Models\Promotion;

class PromoteEmployee
{
    public function __invoke(){
        $promotions = Promotion::with('employee')->where('promotion_date', now()->format("Y-m-d"))->get();
        foreach($promotions as $promotion){
            $promotion->employee->designation_id = $promotion->new_designation_id;
            $promotion->employee->salary = $promotion->new_salary;
            $promotion->employee->save();
        }
    }

}