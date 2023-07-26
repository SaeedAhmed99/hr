<?php

namespace App\Models;

use App\Models\Project;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmployeeProject extends Pivot
{
    use HasFactory;

    protected $table = 'employee_project';

    public function timeTrackers()
    {
        return $this->hasMany(TimeTracker::class, 'employee_project_id', 'id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
