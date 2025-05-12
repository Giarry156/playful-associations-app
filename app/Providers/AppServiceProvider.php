<?php

namespace App\Providers;

use Carbon\Carbon;
use Filament\Support\Facades\FilamentIcon;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Carbon::setLocale('it');
        setlocale(LC_TIME, 'it_IT.UTF-8');
    }
}
