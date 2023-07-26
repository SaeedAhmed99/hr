<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = ['employee_id','loan_type_id','amount','payable_amount','installment_month','installment_amount','paid_amount','activation_date','reason','reference_by'];

    /**
     * Get the allowance's amount
     *
     * @param  string  $value
     * @return string
     */
    public function getAmountAttribute($value)
    {
        return ($value / 100);
    }

    /**
     * Set the allowance's amount
     *
     * @param  string  $value
     * @return void
     */
    public function setAmountAttribute($value)
    {
        $this->attributes['amount'] = round($value * 100);
    }

    /**
     * Get the allowance's amount
     *
     * @param  string  $value
     * @return string
     */
    public function getPayableAmountAttribute($value)
    {
        return ($value / 100);
    }

    /**
     * Set the allowance's amount
     *
     * @param  string  $value
     * @return void
     */
    public function setPayableAmountAttribute($value)
    {
        $this->attributes['payable_amount'] = round($value * 100);
    }

    /**
     * Get the allowance's amount
     *
     * @param  string  $value
     * @return string
     */
    public function getInstallmentAmountAttribute($value)
    {
        return ($value / 100);
    }

    /**
     * Set the allowance's amount
     *
     * @param  string  $value
     * @return void
     */
    public function setInstallmentAmountAttribute($value)
    {
        $this->attributes['installment_amount'] = round($value * 100);
    }

    /**
     * Get the paid amount
     *
     * @param  string  $value
     * @return string
     */
    public function getPaidAmountAttribute($value)
    {
        return ($value / 100);
    }

    /**
     * Set the paid amount
     *
     * @param  string  $value
     * @return void
     */
    public function setPaidAmountAttribute($value)
    {
        $this->attributes['paid_amount'] = round($value * 100);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function loanType()
    {
        return $this->belongsTo(LoanType::class);
    }
}
