<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckSession
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Jika session user_id atau logged_in tidak ada, redirect ke login
        if (!session()->has('user_id') || !session('logged_in')) {
            return redirect()->route('login')
                             ->withErrors(['Silakan login terlebih dahulu.']);
        }

        return $next($request);
    }
}
