<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Exception;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class JWTUserMiddleware extends BaseMiddleware
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
        try
        {
            $user = JWTAuth::parseToken()->authenticate();
        }
        catch(\Exception $e)
        {
            if($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException)
            {
                return response()->json([
                    'status' => 'token_invalid',
                    'message' => 'Token no válido'
                ]);
            }
            else if($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException)
            {
                return response()->json([
                    'status' => 'token_expired',
                    'message' => 'Token caducado'
                ]);
            }
            else if($e instanceof \Tymon\JWTAuth\Exceptions\JWTException)
            {
                return response()->json([
                    'status' => 'token_absent',
                    'message' => 'Token Ausente'
                ]);
            }
            else
            {
                return response()->json([
                    'status' => 'token_nofound',
                    'message' => 'Token de autorización no encontrado'
                ]);
            }
        }
    
        return $next($request);
    }
}
