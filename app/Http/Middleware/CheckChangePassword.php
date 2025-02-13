<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckChangePassword
{

    public function handle(Request $request, Closure $next): Response
    {

        if (auth()->user()->last_login == null) {

            return redirect()->route('formChangePass');
        }
        return $next($request);
    }
}
