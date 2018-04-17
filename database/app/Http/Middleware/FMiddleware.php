<?php

namespace App\Http\Middleware;

use Closure;

class FMiddleware
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
        $usertype = $request->user()->user_type;
        $userfirst = $request->user()->user_firstlogin;
        if($usertype == 1 && $userfirst == 0)
        {
            return $next($request);
        }
        else
        {
            return redirect('/');
        }
    }
}

