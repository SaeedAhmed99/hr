<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'document_id',
        'employee_id',
        'document_value',
    ];

    public function document()
    {
        return $this->belongsTo(Document::class);
    }
}
