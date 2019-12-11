<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if( Auth::check() ){
            return $next($request);
            // if( Auth::user()->role == 'admin' ){
                
            // } else 
            //return redirect()->route('dashbroad'); 
        }
        return redirect()->route('login'); 
    }
}

