<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class StudentMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || auth()->user()->role->role_name !== 'student') {
            abort(403, 'غير مصرح لك بالدخول');
        }

        return $next($request);
    }
}