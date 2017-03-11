<?php

namespace App\Http\Middleware;

use App\User\Model\UserModel;
use App\User\Repository\UserRepository;
use Closure;
use Illuminate\Support\Facades\Auth;

class AutoAuthMiddleware
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
	    $user = JWTAuth::parseToken()->toUser();

	    Auth::login($user);

        return $next($request);
    }
}
