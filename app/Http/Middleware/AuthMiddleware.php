<?php

namespace App\Http\Middleware;

use App\Exceptions\ExceptionArray;
use App\Traits\ResponseTrait;
// use App\Traits\UserJwt;
use Closure;
use Illuminate\Http\Request;

class AuthMiddleware
{
    use ResponseTrait;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            // $token = $request->header('Authorization');

            // if (!$token) {
            //     throw new ExceptionArray("Token de Authorization Requerido", 401);
            // }

            // $user = $this->userDecode($token);
            // if ($user->enable===false){
            //     throw new ExceptionArray("Usuario no autorizado", 401);
            // }
            
            // $request['user'] = $user;
            return $next($request);
        } catch (ExceptionArray $th) {
            return $this->ResponseThrow($th);
        }
    }
}
