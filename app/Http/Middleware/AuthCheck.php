<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AuthCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $bearerToken = $request->bearerToken();

        if(!$bearerToken){
            return response()->json(['error'=>'Unauthorized user. Please log in!'],401);
        }

        if(Auth::guard('api')->user()){
            return $next($request);
        }

        if (!Auth::guard('api')->once(['api_token' => $bearerToken])) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $next($request);
    }
}
