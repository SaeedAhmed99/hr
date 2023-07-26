<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerformanceMetric extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function performanceCriterion()
    {
        return $this->belongsTo(PerformanceCriterion::class);
    }
}
