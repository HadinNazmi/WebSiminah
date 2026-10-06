<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CekHakAkses
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if ($request->user() && in_array($request->user()->role, $roles)) {
            return $next($request);
        }
        return redirect()->route('dashboard');
    }
}