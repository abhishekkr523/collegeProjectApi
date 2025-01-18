<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$allowedRoles)
    {
        $user = $request->user();
        $user_roles = $user->roles->pluck('name')->toArray();
      
        if ($user && count(array_intersect($allowedRoles, $user_roles)) > 0) {
            return $next($request);
        } else {
            return response()->json(['message' => 'Access Denied'], 403);
        }
    }
}
