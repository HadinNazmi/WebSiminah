<?php

namespace App\View\Components\forms;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class input extends Component
{
    /**
     * Create a new component instance.
     */
    public $name;
    public $placeholder;
    public $type;
    public $id;
    public function __construct( $name, $placeholder, $type='text', $id='')
    {
        $this->name = $name;
        $this->placeholder = $placeholder;
        $this->type = $type;
        $this->id = $id;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.forms.input');
    }
}
