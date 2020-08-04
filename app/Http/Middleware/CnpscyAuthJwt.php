<?php

namespace App\Http\Middleware;

use Closure;

use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class CnpscyAuthJwt
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
            if (!$user = JWTAuth::toUser(JWTAuth::getToken())){
                return response()->json([
                    'status' => 400004,
                    'msg' => '无此用户'
                ], 404);
            }
        } catch (TokenExpiredException $e) {
            return response()->json([
                'status' => 400001,
                'msg' => 'token 过期'
            ], $e->getStatusCode());

        } catch (TokenInvalidException $e) {

            return response()->json([
                'status' => 400003,
                'msg' => 'token 失效'
            ], $e->getStatusCode());

        } catch (JWTException $e) {
            return response()->json([
                'status' => 400002,
                'msg' => 'token 参数错误'
            ], $e->getStatusCode());

        }
        return $next($request);
    }
}
