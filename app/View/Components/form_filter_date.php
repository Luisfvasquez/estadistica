<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class form_filter_date extends Component
{
    public string $ruta ;
    /**
     * Create a new component instance.
     */
    public function __construct(string $ruta)
    {
        $this->ruta = $ruta;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form_filter_date');
    }
}
