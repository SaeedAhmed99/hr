<?php

namespace App\Models;

use App\Models\EmployeeProject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;

    public function employees()
    {
        return $this->belongsToMany(Employee::class)->using(EmployeeProject::class)->withPivot('id', 'is_active');
    }

    public function employeeProject()
    {
        return $this->hasMany(EmployeeProject::class);
    }
}
