<?php
/**
 *
 * User: @ 王恒兵
 * Date: 2018/9/26
 * Time: 18:55
 */

namespace app\user\controller;


use think\Controller;

class Wx extends Controller
{
    // 处理支付后的回调
    public function notify(){
        $payPlus = PAY_PLUS.'pay/wxpay/';
        include ($payPlus.'notify.php');
        new \Notify();
    }
}