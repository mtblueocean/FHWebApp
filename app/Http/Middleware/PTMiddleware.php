<?php

namespace FitHabit\Http\Middleware;
use Illuminate\Support\Facades\Auth;
use Closure;

class PTMiddleware
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
        if($request->user() == null)
        {
            return redirect('/');
        }
        
        $usertype = $request->user()->user_type;
        $userfirst = $request->user()->user_firstlogin;
        if($usertype == 1)
        {
            return $next($request);
        }
        else
        {
            return redirect('/');
        }
    }
}
