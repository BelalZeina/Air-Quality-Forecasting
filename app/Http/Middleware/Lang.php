<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Lang
{
    public function handle(Request $request, Closure $next)
    {

        $request->header('Accept-Language' ) == 'ar' ? app()->setLocale('ar') :  app()->setLocale('en');
        
        return $next($request);
    }
}
