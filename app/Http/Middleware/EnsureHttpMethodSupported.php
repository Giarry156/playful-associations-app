<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureHttpMethodSupported
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$methods): Response
    {
        $method = $request->method();
        $supportedMethods = array_map('strtoupper', $methods);

        if (!in_array($method, $supportedMethods)) {
            return response()->json([
                'error' => 'Method Not Allowed',
                'message' => "The HTTP method '$method' is not allowed for this endpoint."
            ], Response::HTTP_METHOD_NOT_ALLOWED);
        }

        return $next($request);
    }
}
