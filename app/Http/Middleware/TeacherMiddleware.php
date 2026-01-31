<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class TeacherMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || auth()->user()->role_id !== 2) {
            abort(403, 'غير مصرح لك بالدخول');
        }

        return $next($request);
    }
}
