<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        if (\Auth::user()->role === $role) {
            Session::flash('message', 'NOT ALLOWED.  INSUFFICIENT RIGHTS.');
            return redirect()->back();
        }

        return $next($request);
    }
}
