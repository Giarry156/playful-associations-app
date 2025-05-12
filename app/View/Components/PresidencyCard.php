<?php

namespace App\View\Components;

use App\Models\Association;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PresidencyCard extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public Association $association,
    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.presidency-card');
    }
}
