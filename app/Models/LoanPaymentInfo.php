<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanPaymentInfo extends Model
{
    use HasFactory;

    protected $fillable = ['employee_id','loan_id','paid_month','salary_slip_id'];
}
