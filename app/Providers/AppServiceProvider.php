<?php

namespace App\Providers;

use App\Models\Cart;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
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
        View::composer(['layouts.app', 'layouts.guest'], function ($view) {
            $user = Auth::user();
            $cartCount = 0;

            if ($user) {
                $cartCount = Cart::getCartCount($user->id);
            }

            $view->with('user', $user);
            $view->with('cartCount', $cartCount);
        });
    }
}
