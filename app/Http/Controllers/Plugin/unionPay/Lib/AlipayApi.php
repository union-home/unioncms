<?php

namespace App\Http\Controllers\Plugin\unionPay\Lib;
/* *
 * 类名：AlipayApi
 */

use App\Models\TransferOrder;
use function GuzzleHttp\Psr7\parse_query;

class AlipayApi {

    protected $appid = '';//应用id
    protected $gateway = '';//请求网关
    protected $rsaPrivateKey = '';//用户密钥
    protected $appURL = '';//回调路径
    protected $totalFee = '';//价格
    protected $outTradeNo = ''; //订单号
    protected $module = '';//模块
    protected $action = '';//方法
    public $alipayrsaPublicKey = '';//支付宝公钥


    //支付宝支付类的构造函数
    function __construct() {
        $this->appURL = url('api/cms/pay/callback/Alipay');
    }

    public function setConfig($name, $value = '') {
        $this->$name = $value;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 订单页面支付（支付宝支付）
     */

    public function pay() {
        $res = $this->order();
        if ($res['status'] != 200) return $res;

        require_once "alipay/AopClient.php";
        require_once "alipay/request/AlipayTradeAppPayRequest.php";


        $aop = new \AopClient;
        //这里是支付宝网关，正式环境用这个即可，沙箱环境网关为    https://openapi.alipaydev.com/gateway.do
        $aop->gatewayUrl = $this->gateway;
        //填写appid，在应用的头上面有
        $aop->appId = $this->appid;
        //这个地方填写私钥，就是我们在上面用工具生成的私钥，这个私钥必须是和上传到支付宝的公钥匹配，不让，支付宝访问的时候会匹配错误
        $aop->rsaPrivateKey = $this->rsaPrivateKey;
        $aop->format = "json";
        $aop->charset = "UTF-8";
        $aop->signType = "RSA2";
        //这个地方的公钥也是一样，必须是上传到支付宝的那个公钥要一样
        $aop->alipayrsaPublicKey = $this->alipayrsaPublicKey;
        //实例化具体API对应的request类,类名称和接口名称对应,当前调用接口名称：alipay.trade.app.pay
        $request = new \AlipayTradeAppPayRequest();
        //SDK已经封装掉了公共参数，这里只需要传入业务参数
        $bizcontent = "{\"body\":\"在线支付\","
            . "\"subject\": \"在线支付\","
            . "\"out_trade_no\": \"$this->outTradeNo\","
            . "\"timeout_express\": \"60m\","
            . "\"total_amount\": \"$this->totalFee\","
            . "\"product_code\":\"QUICK_MSECURITY_PAY\""
            . "}";
        $request->setNotifyUrl($this->appURL);//这个是异步回调地址
        $request->setBizContent($bizcontent);
        //调用sdkExecute生成订单url
        $response = $aop->sdkExecute($request);
        /*htmlspecialchars是为了输出到页面时防止被浏览器将关键参数html转义，实际打印到日志以及http传输不会有这个问题
        *如果这里需要用json返回可以去掉htmlspecialchars
        */

        //$res = htmlspecialchars($response);//就是orderString 可以直接给客户端请求，无需再做处理。
        $res = $response;//就是orderString 可以直接给客户端请求，无需再做处理。
        if (strstr($res, "alipay_sdk")) {
            return json_encode(['status' => 200, 'msg' => '下单成功', 'data' => $res]);
        } else {
            return json_encode(['status' => 0, 'msg' => '下单失败']);
        }

    }

    public function order() {
        return TransferOrder::InsertArr(['order_num' => $this->outTradeNo, 'module' => $this->module, 'action' => $this->action, 'pay_method' => 'Alipay']);
    }

    public function check($outTradeNo) {
        require_once "alipay/AopClient.php";
        require_once "alipay/request/AlipayTradeQueryRequest.php";


        $aop = new \AopClient ();
        $aop->gatewayUrl = $this->gateway;
        $aop->appId = $this->appid;
        $aop->rsaPrivateKey = $this->rsaPrivateKey;
        $aop->alipayrsaPublicKey = $this->alipayrsaPublicKey;
        $aop->apiVersion = '1.0';
        $aop->signType = 'RSA2';
        $aop->postCharset = 'UTF-8';
        $aop->format = 'json';
        $request = new \AlipayTradeQueryRequest ();
        $request->setBizContent("{\"out_trade_no\":\"$outTradeNo\"}");
        $result = $aop->execute($request);
        $responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";
        $resultCode = $result->$responseNode->code;
        $trade_no = $result->$responseNode->trade_no;
        if (!empty($resultCode) && $resultCode == 10000) {
            return json_encode(['status' => 1, 'msg' => '支付成功', 'trade_no' => $trade_no]);
        } else {
            return json_encode(['status' => 0, 'msg' => '订单未支付']);
        }
    }

    public function callback($post) {
        $post = parse_query($post);
        Log::write('支付宝回调：', json_encode($post), 'order/' . date('Y-m') . '/' . date('Y-m-d') . '/' . $post['out_trade_no'] . '.log');

        if ($post['trade_status'] == 'TRADE_SUCCESS') {
            //业务处理
            $post['status'] = 1;
        } else {
            $post['status'] = 2;
        }
        $post['status'] = $post['trade_status'] == 'TRADE_SUCCESS' ? 1 : 2;
        $data['payment_id'] = $post['trade_no'];
        return $post;
    }
}

