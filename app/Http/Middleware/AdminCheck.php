<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminCheck
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->is_admin == 1 && Auth::user()->status == 0) {
            return $next($request);
        }

        return redirect()->route('home.index')->with('error', 'Bạn không có quyền truy cập vào trang admin!');
    }
}