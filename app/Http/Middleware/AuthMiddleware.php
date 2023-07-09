<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Config;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // $value = Cache::get('userData');

        // if ($value !== null) {
        //     Config::set('database.connections.mysql.database', $value);
        //     app('db')->purge();
        // }
        if (Auth::user()) {
            Config::set('database.connections.mysql.database', Auth::user()->db_name);
            app('db')->purge();
        }

        return $next($request);
    }
}
