<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class Authenticate
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
        // Check if user is authenticated (you can customize this based on your auth system)
        if (!session()->has('user_id')) {
            // Store the intended URL in the session
            session()->put('url.intended', $request->url());

            // Redirect to login page with a message
            return redirect()->route('login')->with('error', 'You must be logged in to access this page.');
        }

        return $next($request);
    }
}
