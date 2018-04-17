<?php

namespace App\Http\Middleware;
use App\Program;
use Closure;

class PTPMiddleWare
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
        $programid = $request->programid;
        $makerid = $request->userid;
        $userid = $request->user()->id;
        if($makerid != $userid)
        {
            return redirect()->back();
        }
        else
        {
            $program = Program::where(['program_id' => $programid, 'program_maker' => $makerid])
                ->get();
            if(count($program) > 0)
            {
                return $next($request);
            }
            else
            {
                return redirect()->back();
            }
        }
    }
}
