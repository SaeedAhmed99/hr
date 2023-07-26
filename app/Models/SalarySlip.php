<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalarySlip extends Model
{
    use HasFactory;

    protected $fillable = ['total_earning','employee_id','net_payable','salary_month','status','basic_salary','allowance','commission','deduction','loan','other_payment','overtime'];

    protected $casts = [
        'salary_month' => 'datetime'
    ];

    /**
     * Get the total_earning amount
     *
     * @param  string  $value
     * @return string
     */
    public function getTotalEarningAttribute($value)
    {
        return ($value / 100);
    }

    /**
     * Set the total_earning amount
     *
     * @param  string  $value
     * @return void
     */
    public function setTotalEarningAttribute($value)
    {
        $this->attributes['total_earning'] = round($value * 100);
    }    

    /**
     * Get the net_payable amount
     *
     * @param  string  $value
     * @return string
     */
    public function getNetPayableAttribute($value)
    {
        return ($value / 100);
    }

    /**
     * Set the net_payable amount
     *
     * @param  string  $value
     * @return void
     */
    public function setNetPayableAttribute($value)
    {
        $this->attributes['net_payable'] = round($value * 100);
    }

    /**
     * Get the basic_salary amount
     *
     * @param  string  $value
     * @return string
     */
    public function getBasicSalaryAttribute($value)
    {
        return ($value / 100);
    }

    /**
     * Set the basic_salary amount
     *
     * @param  string  $value
     * @return void
     */
    public function setBasicSalaryAttribute($value)
    {
        $this->attributes['basic_salary'] = round($value * 100);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
