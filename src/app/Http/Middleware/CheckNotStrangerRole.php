<?php

namespace App\Http\Middleware;

use App\Enums\UserRoleEnum;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckNotStrangerRole
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request The incoming request.
     * @param Closure $next    The next middleware closure.
     *
     * @return Response The response from the next middleware or a redirect response.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user() && $request->user()->role->name === UserRoleEnum::Stranger->value) {
            return redirect(route('authorization.notice'));
        }
        return $next($request);
    }
}
