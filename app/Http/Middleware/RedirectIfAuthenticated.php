<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Auth\RedirectToClient;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    use RedirectToClient;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            return redirect($this->redirectTo());
//            return redirect('/home');
        }

        return $next($request);
    }
}
