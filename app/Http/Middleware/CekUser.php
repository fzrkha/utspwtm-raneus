<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CekUser
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, $roles)
    {
        if (!Auth::check()) {
            return redirect('/')->withErrors('Anda harus login terlebih dahulu');
        }

        $user = Auth::user();

        if ($user->level == $roles) {
            return $next($request);
        } else {
            return redirect('/')->withErrors('Anda harus login terlebih dahulu');
        }
    }
}
