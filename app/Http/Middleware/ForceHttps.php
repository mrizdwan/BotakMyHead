<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ForceHttps
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if the request is secure
        if (!$request->secure() && !$request->isLocal()) {
            return redirect()->secure($request->getRequestUri());
        }

        return $next($request);
    }
}
