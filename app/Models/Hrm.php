<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hrm extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'active_status',
        'last_login',
    ];
}
