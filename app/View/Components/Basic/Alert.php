<?php

namespace App\View\Components\Basic;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Alert extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $title,
        public string $text,
        public string $type = 'basic',
        public string $color = 'primary',
        public string $icon = 'fa-circle'
    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.basic.alert');
    }
}
