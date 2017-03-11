<?php

namespace App\Http\Middleware;

use App\Exceptions\AuthException;
use Closure;

class ApiAuthMiddleware
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
    	if(!auth()->check())
	    {
		    throw new AuthException('Authentication error.');
	    }

        return $next($request);
    }
}
