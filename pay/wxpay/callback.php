<?php
include './Base.php';
/* 
 * 童攀课堂
 * https://www.tongpankt.com/
 */

class WeiXinBack extends Base
{
    public function __construct() {
        parent::__construct();
        //接受微信服务器发送的数据
        $data = $this->getPost();
        $arr = $this->XmlToArr($data);
        //记录数据到日志中
       // $this->logs('log.txt', $arr);
        //验证签名
       if( $this->checkSign($arr)){
           //调用统一下单API
           $params = [
               'appid'=> self::APPID,
                'mch_id'=> self::MCHID,
                'nonce_str'=>md5(time()),
                'body'=> '扫码支付模式一',
                'out_trade_no'=> $arr['product_id'],
                'total_fee'=> 2,
                'spbill_create_ip'=>$_SERVER['SERVER_ADDR'],
                'notify_url'=> self::NOTIFY,
                'trade_type'=>'NATIVE',
                'product_id'=>$arr['product_id']
           ];
           $arr =  $this->unifiedorder($params);
           $return_params = [
               'return_code'  => 'SUCCESS',
                'appid'  => self::APPID,
                'mch_id'  => self::MCHID,
                'nonce_str'  => md5(time()),
                'prepay_id'  => $arr['prepay_id'],
                'result_code'=> 'SUCCESS'
           ];
           $return_params = $this->setSign($return_params);
           $return_xml = $this->ArrToXml($return_params);
           echo $return_xml;
           //获取到prepay_id
           //返回prepay_id等数据
          // $this->logs('log.txt', '1');
       }else{
          // $this->logs('log.txt', '签名校验失败');
       }
    }
    //

}

new WeiXinBack();