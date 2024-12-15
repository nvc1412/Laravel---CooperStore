<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // if (auth()->check()) {
        //     return $next($request);
        // }
        // return redirect()->route("home.index")->with("error", "Bạn chưa đăng nhập! Vui lòng đăng nhập để sử dụng dịch vụ!");


        if (auth()->check()) {
            if (auth()->user()->email_verified_at == "") {
                auth()->logout();
                return redirect()->route("home.index")->with("error", "Tài khoản chưa được xác thực! Vui lòng kiểm tra email của bạn để xác thực tài khoản!");
            }
            if (auth()->user()->status == 1) {
                auth()->logout();
                return redirect()->route("home.index")->with("error", "Tài khoản của bạn đang bị khóa! Vui lòng liên hệ hoặc gọi hotline để biết thêm chi tiết!");
            }
        } else {
            return redirect()->route("home.index")->with("error", "Bạn chưa đăng nhập! Vui lòng đăng nhập để sử dụng dịch vụ!");
        }

        return $next($request);
    }
}