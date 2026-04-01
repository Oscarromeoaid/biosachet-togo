<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdminRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        abort_unless($user?->isAdmin(), 403);

        if ($roles !== [] && ! $user->hasAnyAdminRole($roles)) {
            abort(403);
        }

        return $next($request);
    }
}
