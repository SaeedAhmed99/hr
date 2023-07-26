<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commission extends Model
{
    use HasFactory;

    protected $fillable = ['employee_id','title','amount','type','recurring','compliance'];

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
        $this->attributes['amount'] = ($value * 100);
    }

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
    ];
}
