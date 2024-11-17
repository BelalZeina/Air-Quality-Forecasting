<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class Localization
{

    public function handle(Request $request, Closure $next)
    {
        if (Session::has('locale')) {
            app()->setlocale(Session::get('locale'));
        }

        return $next($request);
    }
}
