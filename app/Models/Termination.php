<?php

namespace App\Models;

use App\Models\Employee;
use App\Models\TerminationType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Termination extends Model
{
    use HasFactory;

     use HasFactory;

     protected $fillable = [
        'employee_id',
        'termination_type_id',
        'notice_date',
        'termination_date',
        'description',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
    public function termination_type()
    {
        return $this->belongsTo(TerminationType::class);
    }

}
