<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Award extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'award_type_id',
        'date',
        'gift',
        'description',
    ];

    public function awardType()
    {
        return $this->belongsTo(AwardType::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
