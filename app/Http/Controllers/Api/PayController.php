<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PayController extends Controller {
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request) {
        parent::__construct($request);

    }

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

    //支付回调
    public function callback(Request $request, $pay_method) {
        $data = $this->getData();
        event(new \App\Events\UnionPay($request, __E('pay_driver'), 'callback', $data, $pay_method));
    }
}
