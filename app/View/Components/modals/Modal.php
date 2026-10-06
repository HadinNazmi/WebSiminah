<?php

namespace App\View\Components\modals;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Modal extends Component
{
    /**
     * Create a new component instance.
     */
    public $modalName;
    public $title;
    public function __construct($modalName, $title)
    {
        $this->modalName = $modalName;
        $this->title = $title;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.modals.Modal');
    }
}
