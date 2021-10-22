<?php

namespace App\Http\Middleware;

use App\Traits\GoogleAuthenticator;
use Closure;
use Illuminate\Routing\Route;

class TFAVerify
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->user()['2fa_mode'] === "DISABLED" ) {
            return $next($request);
        }
        if(
            $request->session()->has('2fa_code') &&
            $request->session()->has('2fa_code_time') &&
            GoogleAuthenticator::Make()->verifyCode(
                $request->user()['2fa_secret'],
                $request->session()->get('2fa_code'),
                14,
                $request->session()->get('2fa_code_time')
            )
        )
            return $next($request);

        return redirect('/2fa/required?return='.$request->path());

    }
}
