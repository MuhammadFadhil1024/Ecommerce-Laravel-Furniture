<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        return $next($request);
        try {
            if (!$request->header('Authorization')) {
                throw new AuthenticationException('Token not found !');
            }
        } catch (AuthenticationException $exception) {
            return response()->json(['error' => $exception->getMessage()], Response::HTTP_UNAUTHORIZED);
        }
    }
}
