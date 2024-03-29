<?php

namespace App\Http\Middleware;

use Closure;

use Auth;

class Tutor
{
    
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role == 'tutor' ) {
            return $next($request);
        }
        elseif (Auth::check() && Auth::user()->role == 'student') {
            return redirect('/student');
        } else {
            return redirect('/admin');
        }
    }
}
