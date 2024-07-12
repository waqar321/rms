<?php

namespace App\Http\Middleware;

// use App\Models\ecom_activity_admin_log;
use Closure;
use Illuminate\Http\Request;

class LogActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        if (auth()->check()) 
        {
            // ecom_activity_admin_log::AddActivity();
        }

        return $next($request);
    }
}
