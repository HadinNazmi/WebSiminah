<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class progressBar extends Component
{
    /**
     * Create a new component instance.
     */
    public $value;
    public $max;
    public $type;
    public $color;
    public function __construct($value, $max, $type="kontainer", $color="green")
    {
        $this->value = $value;
        $this->max = $max;
        $this->type = $type;
        $this->color = $color;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.progressBar');
    }
}
