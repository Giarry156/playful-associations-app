<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class WeegaGamesSlider extends Component
{
    public string $id;

    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $sliderTitle = "",
        public string $showAllLink = "",
    )
    {
        $this->id = "games-slider-" . uniqid();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.weega-games-slider');
    }
}
