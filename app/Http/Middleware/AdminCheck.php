<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminCheck
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && isAdmin() && isActive()) {
            return $next($request);
        }

        session()->flash("error", "Bạn không có quyền truy cập vào trang admin!");
        return redirect()->route('home.index');
    }
}