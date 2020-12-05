<?php

namespace App\Http\Controllers\Plugin\unionPay\Lib;
/* *
 * 类名：WeChatApi
 */

use App\Models\TransferOrder;

class WeChatApi {
    //===========【基本信息设置】===========
    //微信公众号身份的唯一标识 （小程序）
    protected $APPID = '';  //填写您的appid，微信公众平台里的
    protected $APPSECRET = '';
    //受理商ID,身份标识
    protected $MCHID = '';  //商户id
    //商户支付密钥Key
    protected $KEY = '';
    //回调通知接口
    protected $APPURL = '';
    //交易类型
    protected $TRADETYPE = '';
    //商品类型信息
    protected $BODY = '在线支付';
    //openid
    protected $openid = '';
    //价格
    protected $totalFee = '';
    //订单号
    protected $outTradeNo = '';
    //模块
    protected $module = '';
    //方法
    protected $action = '';

    public $params = [];

    //公众号资料
    //protected $JSAPIAPPID = '';
    //protected $JSAPIAPPSECRET = '';

    //微信支付类的构造函数
    function __construct() {
        $this->APPURL = url('api/cms/pay/callback/WeChat');
    }

    public function setConfig($name, $value = '') {
        $this->$name = $value;
    }

    /*public function appIdAndSecret($pay_type, $openid) {
        //有其他方式在此累加
        if ($pay_type == 'JSAPI') {//
            $this->openid = $openid; //用户唯一标识
            $this->APPID = $this->JSAPIAPPID;
            $this->APPSECRET = $this->JSAPIAPPSECRET;
            $this->TRADETYPE = $pay_type; //类型
        } else {

        }
    }*/

    /*public function init($outTradeNo, $totalFee, $openid, $pay_type) {
        $this->appIdAndSecret($pay_type, $openid);
        $this->outTradeNo = $outTradeNo; //商品编号
        $this->totalFee = $totalFee; //总价
//        $this->APPURL = url('module/uniontool/goods/order/WeChatCallback');
    }*/

    /*public function initCheck($outTradeNo, $pay_type = 'APP') {
        $this->appIdAndSecret($pay_type, '');
        $this->outTradeNo = $outTradeNo; //商品编号
    }*/

    //微信支付类向外暴露的支付接口
    public function pay() {
        $res = $this->order();
        if ($res['status'] != 200) return $res;
        //$this->init($outTradeNo, $totalFee, $openid, $pay_type);
        $result = $this->weixinapp($this->TRADETYPE);
        return $result;
    }

    public function order() {
        $res = TransferOrder::InsertArr(['order_num' => $this->outTradeNo, 'module' => $this->module, 'child_module' => $this->params['child_module'], 'action' => $this->action, 'pay_method' => 'WeChat']);
        if ($res) {
            return ['status' => 200, 'msg' => '中转下单成功'];
        } else {
            return ['status' => 0, 'msg' => '中转下单失败'];
        }
    }

    //对微信统一下单接口返回的支付相关数据进行处理
    private function weixinapp($pay_type) {
        $unifiedorder = $this->unifiedorder();
        if (@$unifiedorder['return_code'] == 'FAIL' || @$unifiedorder['result_code'] == 'FAIL') return ['status' => 0, 'msg' => $unifiedorder['return_msg']];
        $time = time();//时间戳
        $noncestr = $this->createNoncestr();//随机串
        if ($pay_type == 'APP') {
            $parameters = array(
                'appid' => $this->APPID,
                'partnerid' => $this->MCHID,
                'prepayid' => $unifiedorder['prepay_id'],//
                'package' => 'Sign=WXPay',
                'noncestr' => $noncestr,//随机串
                'timestamp' => '' . $time . '',
            );
            $parameters['sign'] = $this->getSign($parameters);
        } else {
            $parameters = array(
                'appId' => $this->APPID,//小程序ID
                'timeStamp' => '' . $time . '',//时间戳
                'nonceStr' => $noncestr,//随机串
                'package' => 'prepay_id=' . $unifiedorder['prepay_id'],//数据包
                'signType' => 'MD5'//签名方式
            );
            $parameters['paySign'] = $this->getSign($parameters);
        }

        return ['status' => 200, 'msg' => '成功', 'data' => $parameters];
    }

    //请求微信统一下单接口
    private function unifiedorder() {
        $parameters = array(
            'appid' => $this->APPID,//应用id
            'mch_id' => $this->MCHID,//商户id
            'nonce_str' => $this->createNoncestr(),//随机字符串
            'body' => $this->BODY, //商品信息
            'out_trade_no' => $this->outTradeNo,//商户订单编号
            'total_fee' => intval($this->totalFee), //总金额
            'spbill_create_ip' => $_SERVER['REMOTE_ADDR'],//终端ip
            'notify_url' => $this->APPURL, //通知地址
            'trade_type' => $this->TRADETYPE,//交易类型
        );
        if ($this->TRADETYPE != 'APP') $parameters['openid'] = $this->openid;//用户openid

        $parameters['sign'] = $this->getSign($parameters);
        $xmlData = $this->arrayToXml($parameters);
        $xml_result = $this->postXmlCurl($xmlData, 'https://api.mch.weixin.qq.com/pay/unifiedorder', 60);
        $result = $this->xmlToArray($xml_result);

        return $result;
    }

    //数组转字符串方法
    protected function arrayToXml($arr) {
        $xml = "<xml>";

        foreach ($arr as $key => $val) {
            if (is_numeric($val)) {
                $xml .= "<" . $key . ">" . $val . "</" . $key . ">";
            } else {
                $xml .= "<" . $key . "><![CDATA[" . $val . "]]></" . $key . ">";
            }
        }
        $xml .= "</xml>";

        return $xml;
    }

    protected function xmlToArray($xml) {
        $array_data = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        return $array_data;

    }

    //发送xml请求方法
    private static function postXmlCurl($xml, $url, $second = 30) {
        $ch = curl_init();

        //设置超时
        curl_setopt($ch, CURLOPT_TIMEOUT, $second);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); //严格校验

        //设置header
        curl_setopt($ch, CURLOPT_HEADER, FALSE);

        //要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

        //post提交方式
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
        curl_setopt($ch, CURLOPT_TIMEOUT, 40);

        set_time_limit(0);

        //运行curl
        $data = curl_exec($ch);

        //返回结果
        if ($data) {
            curl_close($ch);
            return $data;
        } else {
            $error = curl_errno($ch);
            curl_close($ch);
            throw new WxPayException("curl出错，错误码:$error");
        }
    }

    //对要发送到微信统一下单接口的数据进行签名
    protected function getSign($Obj) {
        foreach ($Obj as $k => $v) {
            $Parameters[$k] = $v;
        }

        //签名步骤一：按字典序排序参数
        ksort($Parameters);
        $String = $this->formatBizQueryParaMap($Parameters, false);
        //签名步骤二：在string后加入KEY
        $String = $String . "&key=" . $this->KEY;
        //签名步骤三：MD5加密
        $String = md5($String);
        //签名步骤四：所有字符转为大写
        $result_ = strtoupper($String);

        return $result_;
    }

    //排序并格式化参数方法，签名时需要使用
    protected function formatBizQueryParaMap($paraMap, $urlencode) {
        $buff = "";

        ksort($paraMap);
        foreach ($paraMap as $k => $v) {
            if ($urlencode) {
                $v = urlencode($v);
            }

            //$buff .= strtolower($k) . "=" . $v . "&";
            $buff .= $k . "=" . $v . "&";
        }

        $reqPar = '';
        if (strlen($buff) > 0) {
            $reqPar = substr($buff, 0, strlen($buff) - 1);
        }

        return $reqPar;
    }

    //生成随机字符串方法
    protected function createNoncestr($length = 32) {
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        $str = "";

        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }

        return $str;
    }

    //微信支付查询
    public function check($outTradeNo) {
        $this->initCheck($outTradeNo);
        $parameters = array(
            'appid' => $this->APPID,//小程序id
            'mch_id' => $this->MCHID,//商户id
            'out_trade_no' => $this->outTradeNo,//商户订单编号
            'nonce_str' => $this->createNoncestr(),//随机字符串
        );
        $parameters['sign'] = $this->getSign($parameters);
        $xmlData = $this->arrayToXml($parameters);
        $xml_result = $this->postXmlCurl($xmlData, 'https://api.mch.weixin.qq.com/pay/orderquery', 60);
        $result = $this->xmlToArray($xml_result);
        return $result;
    }

    //回调获取数据
    function getData() {
        if ($GLOBALS['HTTP_RAW_POST_DATA']) {
            $data = $GLOBALS['HTTP_RAW_POST_DATA'];
        } else if ($_POST['HTTP_RAW_POST_DATA']) {
            $data = $_POST['HTTP_RAW_POST_DATA'];
        } else if ($_GET['HTTP_RAW_POST_DATA']) {
            $data = $_GET['HTTP_RAW_POST_DATA'];
        } else {
            $data = file_get_contents('php://input');
        }
        return $data;
    }

    //返回微信成功接收
    function wxSuccess() {
        return '<xml><return_code><![CDATA[SUCCESS]]></return_code><return_msg><![CDATA[OK]]></return_msg></xml>';
    }

    //支付回调
    public function callback($xml) {
        //获取数据
//        $xml = $this->getData();

        //xml转数组
        $data = $this->xmlToArray($xml);
        Log::write('微信回调：', $xml, 'order/' . date('Y-m') . '/' . date('Y-m-d') . '/' . $data['out_trade_no'] . '.log');
        Log::write('解析：', json_encode($data), 'order/' . date('Y-m') . '/' . date('Y-m-d') . '/' . $data['out_trade_no'] . '.log');

        //返回微信成功接收回应
        echo $this->wxSuccess();
        $data['status'] = $data['result_code'] == "SUCCESS" ? 1 : 2;
        $data['payment_id'] = $data['transaction_id'];
        return $data;

    }

    /**
     * @param $url
     * @param $data
     * @param string $method
     * @param string $type
     * @return bool|string
     */
    function curlData($url, $data = [], $method = 'GET', $type = 'json') {
        //初始化
        $ch = curl_init();
        $headers = [
            'form-data' => ['Content-Type: multipart/form-data'],
            'json' => ['Content-Type: application/json'],
        ];
        if ($method == 'GET') {
            if ($data) {
                $querystring = http_build_query($data);
                $url = $url . '?' . $querystring;
            }
        }
        // 请求头，可以传数组
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers[$type]);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);         // 执行后不直接打印出来
        if ($method == 'POST') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');     // 请求方式
            curl_setopt($ch, CURLOPT_POST, true);               // post提交
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);              // post的变量
        }
        if ($method == 'PUT') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }
        if ($method == 'DELETE') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // 不从证书中检查SSL加密算法是否存在
        $output = curl_exec($ch); //执行并获取HTML文档内容
        curl_close($ch); //释放curl句柄
        return $output;
    }

    //获取微信code
    public function getCode($data) {
        $url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=' . $this->APPID . '&redirect_uri=' . urlencode($data['callback']) . '&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect';
        return redirect($url);
    }

    public function codeGetWeChatInfo($data) {
        $url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid=' . $this->APPID . '&secret=' . $this->APPSECRET . '&code=' . $data['code'] . '&grant_type=authorization_code';
        $res = $this->curlData($url);
        dd($res);
    }
}

