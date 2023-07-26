<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerformanceCriterion extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function metric()
    {
        return $this->hasMany('App\Models\PerformanceMetric', 'performance_criterion_id', 'id');
    }
}
