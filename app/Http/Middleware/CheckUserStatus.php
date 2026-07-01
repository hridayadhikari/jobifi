<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle($request, Closure $next)
{
    if (
        auth()->check() &&
        !auth()->user()->is_active
    ) {

        auth()->logout();

        return redirect()
            ->route('login')
            ->withErrors([
                'email' => 'Your account has been suspended by an administrator.',
            ]);
    }

    return $next($request);
}
}
