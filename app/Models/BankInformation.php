<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankInformation extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'account_holder_name',
        'account_number',
        'bank_name',
        'bank_identifier_code',
        'bank_location',
        'tax_payer_id',
    ];
}
