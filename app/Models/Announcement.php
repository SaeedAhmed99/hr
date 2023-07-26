<?php

namespace App\Models;

use App\Models\MeetingBranch;
use App\Models\MeetingEmployee;
use App\Models\MeetingDepartment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'start_date',
        'end_date',
        'description',

    ];

     public function braches()
    {
        return $this->hasMany(MeetingBranch::class);
    }
    public function departments()
    {
        return $this->hasMany(MeetingDepartment::class);
    }
    public function employees()
    {
        return $this->hasMany(MeetingEmployee::class);
    }
}
