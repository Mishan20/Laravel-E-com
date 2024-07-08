<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

class Localization
{
    public function handle(Request $request, Closure $next)
    {
        if (session()->has('locale')) {
            Log::info('Locale set to: ' . session()->get('locale'));
            App::setLocale(session()->get('locale'));
        } else {
            Log::info('Locale not set in session');
        }

        return $next($request);
    }
}