<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiKeyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $apiKey = $request->header('X-API-Key');

        if ($apiKey !== 'a1190f08-1191-42e6-85aa-e7bbe63f3d52') {
            return response()->json(['error' => 'Invalid API key'], 401);
        }

        return $next($request);
    }

}
