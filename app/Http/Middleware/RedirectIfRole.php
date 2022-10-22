<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Exceptions\UnauthorizedException;

class RedirectIfRole
{
    /**
     * @param Request $request
     * @param Closure $next
     * @param mixed   $role
     * @param null    $guard
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|mixed
     */
    public function handle(Request $request, Closure $next, mixed $role, $guard = null)
    {
        $authGuard = Auth::guard($guard);

        if ($authGuard->guest()) {
            throw UnauthorizedException::notLoggedIn();
        }

        $roles = is_array($role)
            ? $role
            : explode('|', $role);

        /** @var User|null $user */
        $user = $authGuard->user();

        if (!$user) {
            return $next($request);
        }

        if ($user->hasAnyRole($roles)) {
            return redirect(route('page.welcome'));
        }

        return $next($request);
    }
}
