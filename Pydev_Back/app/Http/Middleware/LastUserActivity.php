<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
class LastUserActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->role != 'ROLE_ADMIN') {
            $id = auth()->user()->id;
            Cache::put('user-is-online-' . $id, true, Carbon::now()->addMinutes(1));
            auth()->user()->update(['last_login' => now()->addHours(1)]);
        }
        return $next($request);
    }
}
