<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resignation extends Model
{
    use HasFactory;

     protected $fillable = [
        'employee_id',
        'notice_date',
        'resignation_date',
        'description',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
