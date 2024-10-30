<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CheckAdmin
{
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is authenticated and has the 'admin' role
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            // Set a flash message
            Session::flash('message', 'You must be an admin to access this page.');

            // Redirect to the profile or any other page
            return redirect()->route('account.profile');
        }

        return $next($request);
    }
}
