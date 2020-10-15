<?php

namespace App\Http\Middleware;

use Closure;

class CheckUserVerificationMiddleWare
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
        if(auth()->user()->email_verified_at == null){
            return  redirect()->route('dashboard')->with('message','Sorry, Email is not verified');
        }
        return $next($request);
    }
}
