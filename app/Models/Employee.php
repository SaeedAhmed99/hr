<?php

namespace App\Models;

use App\Models\Branch;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'dob',
        'gender',
        'phone',
        'address',
        'employee_id',
        'branch_id',
        'department_id',
        'designation_id',
        'date_of_joining',
        'documents',
        'salary_type',
        'salary',
        'shift_id',
        'compliance_salary',
        'can_overtime',
        'start_time',
        'end_time',
        'persist_time',
        'reporting_boss_id'
    ];

    /**
     * Get the salary amount
     *
     * @param  string  $value
     * @return string
     */
    public function getSalaryAttribute($value)
    {
        return ($value / 100);
    }

    /**
     * Set the salary amount
     *
     * @param  string  $value
     * @return void
     */
    public function setSalaryAttribute($value)
    {
        $this->attributes['salary'] = ($value * 100);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function employee_documents()
    {
        return $this->hasMany(EmployeeDocument::class);
    }

    public function designation()
    {
        return $this->belongsTo(Designation::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function allowances()
    {
        return $this->hasMany(Allowance::class);
    }

    public function commissions()
    {
        return $this->hasMany(Commission::class);
    }

    public function deductions()
    {
        return $this->hasMany(Deduction::class);
    }

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    public function salarySlip()
    {
        return $this->hasMany(SalarySlip::class);
    }

    public function attendance()
    {
        return $this->hasMany(AttendanceEmployee::class);
    }

    public function todaysAttendance()
    {
        return $this->hasOne(AttendanceEmployee::class)->wheredate('clock_in', now()->format("Y-m-d"));
    }

    public function leaveApplied()
    {
        return $this->hasMany(Leave::class);
    }

    public function todayOnLeave()
    {
        return $this->hasOne(Leave::class)->where('start_date', '<=', now()->format("Y-m-d"))->where('end_date', '>=', now()->format("Y-m-d"))->where('status', 1);
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class)->using(EmployeeProject::class)->withPivot('id', 'is_active');
    }

    public function employeeProject()
    {
        return $this->hasMany(EmployeeProject::class);
    }

    public function timeTrackers()
    {
        return $this->hasMany(TimeTracker::class);
    }

    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }
}
