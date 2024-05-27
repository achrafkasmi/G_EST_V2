<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CustomMaintenanceMode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (app()->isDownForMaintenance()) {
            return response()->view('errors.error503', [], 503);
        }

        return $next($request);
    }
}
