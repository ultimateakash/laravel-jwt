<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Database\QueryException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class ApiMiddleWare
{
    public function handle(Request $request, Closure $next)
    {
        try {
            JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            if ($e instanceof TokenInvalidException) {
                $error = 'Token is invalid';
            } else if ($e instanceof TokenExpiredException || $e instanceof QueryException) {
                $error = 'Token is expired';
            } else {
                $error = 'Unauthorized';
            }
            return response()->json(['error' => $error], 401);
        }
        return $next($request);
    }
}
