<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeTracker extends Model
{
    use HasFactory;

    public function employeeProjects()
    {
        return $this->belongsTo(EmployeeProject::class, 'employee_project_id', 'id');
    }

    public function screenshots()
    {
        return $this->hasMany(Screenshot::class);
    }
}
