<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the 'api' middleware group. Enjoy building your API!
|
*/

// $http_origin = !isset($_SERVER['HTTP_ORIGIN']) ? '*' : $_SERVER['HTTP_ORIGIN'];
// $http_origin = (empty($http_origin) || $http_origin == null || $http_origin == 'null')  ? '*' : $http_origin;
// $_SERVER['HTTP_ORIGIN'] = $http_origin;
// header('Access-Control-Allow-Origin: ' . $http_origin);
// header('Access-Control-Allow-Credentials: false');//【如果请求方存在域名请求，那么为true;否则为false】
// header('Access-Control-Allow-Headers: Authorization, Origin, X-Requested-With, Content-Type, Access-Control-Allow-Headers, x-xsrf-token, Accept');
// header('Access-Control-Allow-Methods: *');
//  header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS, PATCH');
// if(strtoupper($_SERVER['REQUEST_METHOD'] ?? '') == 'OPTIONS'){  //vue 的 axios 发送 OPTIONS 请求，进行验证
//     // return json([], 200);
//     exit;
// }


//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
//////////////////////     自定义支付回调        ////////////////////////////////////

Route::group(["namespace" => 'Api'], function () {
    Route::any("/cms/pay/callback/{pay_method}", "PayController@callback");
});