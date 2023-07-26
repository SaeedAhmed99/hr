<?php

namespace App\Models;

use App\Models\Hrm;
use App\Models\Employee;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'email_verified_at',
        'remember_token',
        'lang',
        'timezone',
        'avatar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isEmployee()
    {
        return strtolower($this->hrm->type) == 'employee';
    }

    public function hrm()
    {
        return $this->hasOne(Hrm::class, 'user_id', 'id');
    }

    public function employeeIdFormat($number)
    {
        $prefix = "#EMP00";

        return $prefix . sprintf("%05d", $number);
    }

    public function getBranch($branch_id)
    {
        $branch = Branch::where('id', '=', $branch_id)->first();

        return $branch;
    }

    public function getDepartment($department_id)
    {
        $department = Department::where('id', '=', $department_id)->first();

        return $department;
    }

    public function getDesignation($designation_id)
    {
        $designation = Designation::where('id', '=', $designation_id)->first();

        return $designation;
    }

    public function getName($user_id)
    {
        $user_name = User::where('id', '=', $user_id)->first();

        return $user_name;
    }

    public function getEmail($user_id)
    {
        $user_email = User::where('id', '=', $user_id)->first();

        return $user_email;
    }

    public function getBankInfo($employee_id)
    {
        $bankinfo = BankInformation::where('employee_id', '=', $employee_id)->first();

        return $bankinfo;
    }


    public function getEmployee($employee)
    {
        $employee = Employee::where('employee_id', '=', $employee)->first();
        $user = User::where('id', '=', $employee->user_id)->first();

        return $user;
    }

    public function getLeaveType($leave_type)
    {
        $leavetype = LeaveType::where('id', '=', $leave_type)->first();

        return $leavetype;
    }

    public function getUserType()
    {
        $usertype = Auth::user()->with('hrm')->first();

        return $usertype;
    }

    public function employee()
    {
        return $this->hasOne(Employee::class);
    }
}
