<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        // Check if the user has an active session
        if ($request->session()->has('id_user')) {
            // If the user accesses the root URL, redirect to the dashboard
            if ($request->is('/')) {
                return redirect('/dashboard');
            } else {
                return $next($request);
            }
        } else {
            return redirect('/');
        }


    }
}