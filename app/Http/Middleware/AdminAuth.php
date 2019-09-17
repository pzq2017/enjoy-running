<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminAuth
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
        if (!Auth::guard('admin')->check()) {
            if ($request->isXmlHttpRequest()) {
                return response()->json([
                    'status' => 'no_login'
                ]);
            } else {
                return redirect()->route('admin.login')->with('error', '请登录账号后再操作');
            }
        }
        return $next($request);
    }
}
