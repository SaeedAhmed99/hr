<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'old_designation_id',
        'new_designation_id',
        'old_salary',
        'new_salary',
        'promotion_title',
        'promotion_date',
        'description',
        'promoted_by'
    ];

    /**
     * Get the old_salary amount
     *
     * @param  string  $value
     * @return string
     */
    public function getOldSalaryAttribute($value)
    {
        return ($value / 100);
    }

    /**
     * Set the old_salary amount
     *
     * @param  string  $value
     * @return void
     */
    public function setOldSalaryAttribute($value)
    {
        $this->attributes['old_salary'] = ($value * 100);
    }

    /**
     * Get the new_salary amount
     *
     * @param  string  $value
     * @return string
     */
    public function getNewSalaryAttribute($value)
    {
        return ($value / 100);
    }

    /**
     * Set the new_salary amount
     *
     * @param  string  $value
     * @return void
     */
    public function setNewSalaryAttribute($value)
    {
        $this->attributes['new_salary'] = ($value * 100);
    }

    public function old_designation()
    {
        return $this->belongsTo(Designation::class, 'old_designation_id');
    }

    public function new_designation()
    {
        return $this->belongsTo(Designation::class, 'new_designation_id');
    }

     public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
