<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class AuthenticateWithToken
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->header('Authorization');
        $sessionId = $request->header('Session-Id');

        if (!$token || !$sessionId) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $user = Auth::authenticate($token);

        if (!$user) {
            return response()->json(['error' => 'Invalid token'], 401);
        }

        return $next($request);
    }
}
