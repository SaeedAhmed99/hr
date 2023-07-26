<?php

namespace App\Models;

use App\Models\Branch;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Trainer extends Model
{
    use HasFactory;

    protected $fillable = [
        'branch_id',
        'firstname',
        'lastname',
        'contact',
        'email',
        'address',
        'expertise',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
