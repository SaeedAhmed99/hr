<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeePerformance extends Model
{
    use HasFactory;
    protected $fillable = ['employee_id','branch_id','designation_id','performance_month','remark','performed_by'];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
    public function designation()
    {
        return $this->belongsTo(Designation::class);
    }

    public function performed_user()
    {
        return $this->hasOne('App\Models\User','id','performed_by');
    }

     public function performance_score()
    {
        return $this->hasMany(EmployeePerformanceScore::class);
    }


}
