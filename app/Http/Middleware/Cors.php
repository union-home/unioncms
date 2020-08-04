<?php

namespace App\Http\Middleware;
use Closure;

class Cors
{
    /**
     * Handle an incoming request.
     * 关闭跨域设置
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);
		$response->header('Access-Control-Allow-Credentials', 'true');
        $response->header('Access-Control-Allow-Origin', "*");
        $response->header('Access-Control-Allow-Headers', 'Origin, Content-Type, Cookie, Accept, multipart/form-data, application/json, Authorization');
        $response->header('Access-Control-Allow-Methods', 'GET, POST, PATCH, PUT, OPTIONS');
        
        return $response;
    }
}
