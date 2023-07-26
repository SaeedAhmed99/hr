<?php

namespace App\View\Components;

use Illuminate\View\Component;

class YearSelection extends Component
{
    public $selected;
    public $id;
    public $name;
    
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($id = "year", $name = "year", $selected = NULL)
    {
        $this->selected = $selected ?? now()->format("Y");
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.year-selection');
    }
}
