<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class RefreshToken extends BaseMiddleware
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
        try {
            if ($this->auth->parseToken()->authenticate()) {
                return $next($request);
            }
            return $this->responseError();
        } catch (TokenExpiredException $exception) {
            try {
                $token = $this->auth->refresh();
                auth()->onceUsingId($this->auth->manager()->getPayloadFactory()->buildClaimsCollection()->toPlainArray()['sub']);
                return $this->setAuthenticationHeader($next($request), $token);
            } catch (JWTException $exception) {
                return $this->responseError();
            }
        } catch (JWTException $exception) {
            return $this->responseError();
        }
    }

    private function responseError()
    {
        return response()->json([
            'status' => 'error',
            'errCode' => '0001',
            'errMsg' => '登录信息已失效，请重新登录',
        ]);
    }
}
