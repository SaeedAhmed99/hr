<?php

namespace App\View\Components;

use Carbon\Carbon;
use Illuminate\View\Component;

class ClockOutShow extends Component
{
    public $clockedIn;
    public $clockedOut;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($clockedIn, $clockedOut)
    {
        $this->clockedIn = new Carbon($clockedIn);
        $this->clockedOut = new Carbon($clockedOut);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.clock-out-show');
    }
}
