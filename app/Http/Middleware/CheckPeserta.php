<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
class CheckPeserta
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
        if(Auth::user()->is_elimination == 0)
        return $next($request);
        else 
        return redirect()->back()->with('error','Anda sudah tereliminasi');
    }
}
