<?php
include $payPlus.'Base.php';
include $payPlus.'phpqrcode/phpqrcode.php';
use app\admin\model\Order;
/* 
 * 童攀课堂
 * https://www.tongpankt.com/
 */

class WeiXinPay2 extends Base
{
    //1.调用统一下单API 后去二维码支付链接
    public function getQrUrl($pid){
        $order = Order::where(['id'=>$pid])->where(['status'=>1])->find();
        //调用统一下单API
           $params = [
               'appid'=> self::APPID,
                'mch_id'=> self::MCHID,
                'nonce_str'=>md5(time()),
                'body'=> 'PHPMall',
                'out_trade_no'=> $order['order_id'],
                'total_fee'=> $order['payment'] * 100,
                'spbill_create_ip'=>$_SERVER['SERVER_ADDR'],
                'notify_url'=> self::NOTIFY,
                'trade_type'=>'NATIVE',
                'product_id'=>$pid
           ];

       $arr = $this->unifiedorder($params);
       return $arr['code_url'];
    }

}

