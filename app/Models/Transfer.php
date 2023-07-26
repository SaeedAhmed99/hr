<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'old_branch_id',
        'new_branch_id',
        'old_department_id',
        'new_department_id',
        'transfer_date',
        'description',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'new_branch_id','id');
    }
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
    public function department()
    {
        return $this->belongsTo(Department::class, 'new_department_id','id');
    }
}
