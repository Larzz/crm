<?php

namespace App\Http\Middleware;
use Closure;

use Illuminate\Http\Request;

use Auth;
class IsAuthenticated
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

        if (Auth::check()){
            
            return $next($request);
          } else {
            return redirect()->route('home.login');
          }

          return $next($request);
    }
}
