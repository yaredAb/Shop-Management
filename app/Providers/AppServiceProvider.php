<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
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
        View::composer('*', function ($view) {
            $user = Auth::user();
            $user_role = $user ? $user->privilage : null;

            $view->with('site_title', Setting::getValue('site_title'));
            $view->with('background_color', Setting::getValue('background_color'));
            $view->with('primary_color', Setting::getValue('primary_color'));
            $view->with('secondary_color', Setting::getValue('secondary_color'));
            $view->with('button_color', Setting::getValue('button_color'));
            $view->with('user_role', $user_role);
        });
    }
}
