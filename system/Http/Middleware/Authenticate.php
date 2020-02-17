<?php

namespace System\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;
use TrivYeah\Support\ResponseHelper;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class Authenticate
{
    public function handle($request, Closure $next)
    {
        try {
            $token = JWTAuth::parseToken();
            $token->authenticate();

        } catch (JWTException $e) {

            if ($e instanceof TokenInvalidException) {
                return ResponseHelper::fail("Token is Invalid", Response::HTTP_UNAUTHORIZED);
            } else if ($e instanceof TokenExpiredException) {
                return ResponseHelper::fail("Token is Expired", Response::HTTP_UNAUTHORIZED);
            } else {
                return ResponseHelper::fail("You're not logged in", Response::HTTP_UNAUTHORIZED);
            }
        }

        return $next($request);
    }
}
