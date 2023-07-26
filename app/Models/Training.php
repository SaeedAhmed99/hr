<?php

namespace App\Models;

use App\Models\Branch;
use App\Models\Trainer;
use App\Models\TrainingType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Training extends Model
{
    use HasFactory;

    protected $fillable = [
        'branch_id',
        'training_type_id',
        'trainer_id',
        'employee_id',
        'trainer_option',
        'training_cost',
        'start_date',
        'end_date',
        'description',
        'performance',
        'status',
        'remarks'
    ];


    public static $options = [
        'Internal',
        'External',
    ];

    public static $Status = [
        'Pending',
        'Started',
        'Completed',
        'Terminated',
    ];

    public static $performance = [
        'Not Concluded',
        'Satisfactory',
        'Average',
        'Poor',
        'Excellent',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
    public function traningtype()
    {
        return $this->belongsTo(TrainingType::class, 'training_type_id','id');
    }
    public function trainer()
    {
        return $this->belongsTo(Trainer::class);
    }
}
