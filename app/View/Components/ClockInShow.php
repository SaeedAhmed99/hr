<?php

namespace App\View\Components;

use Carbon\Carbon;
use Illuminate\View\Component;

class ClockInShow extends Component
{
    public $clockedIn;
    public $attendanceId;
    
    /**
     * Create a new component instance.
     *
     * @param string $clockedIn Clock in
     * @param integer $attendanceId Id of Attendance table
     * @return void
     */
    public function __construct($clockedIn, $attendanceId)
    {
        $this->clockedIn = new Carbon($clockedIn);
        $this->attendanceId = $attendanceId;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.clock-in-show');
    }
}
