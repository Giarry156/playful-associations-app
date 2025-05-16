<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class WeegaUserNotification extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $notificationType = "advice",
        public string $notificationTitle = ""
    )
    {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.weega-user-notification');
    }
}
