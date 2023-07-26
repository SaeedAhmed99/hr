<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'date',
        'time',
        'description',

    ];

     public function meeting_braches()
    {
        return $this->hasMany(MeetingBranch::class);
    }
    public function meeting_departments()
    {
        return $this->hasMany(MeetingDepartment::class);
    }
    public function meeting_employees()
    {
        return $this->hasMany(MeetingEmployee::class);
    }
}
