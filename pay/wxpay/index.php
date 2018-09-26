<?php
include './Base.php';
include './phpqrcode/phpqrcode.php';
/* 
 * 童攀课堂
 * https://www.tongpankt.com/
 */

class WeiXinPay extends Base
{
    //模拟数据可以删除该方法
    public function checks(){
           $params = [
            'appid'     =>  '323213243',
            'mch_id'    =>  'ewr3434',
            'body'      =>  'http://www.tongpankt.com童攀课堂',
            'sign'   =>  'E761C7AEE0D20373A27A92A8432E3046'
        ];
        if($this->checkSign($params)){
            echo '签名校验通过';
        }else{
            echo '签名校验失败！';
        }
    }
    //获取构建二维码的URL地址
    public function getQRurl($oid){
        $params = [
            'appid'             => self::APPID,
            'mch_id'            => self::MCHID,
            'product_id' 	=> $oid,
            'time_stamp' 	=> time(),
            'nonce_str' 	=> md5(time()),
        ];
        
      return 'weixin://wxpay/bizpayurl?' . $this->arrToUrl($this->setSign($params));
    }
     
   
}

$obj = new WeiXinPay();
if(isset($_GET['pid'])){
    QRcode::png($obj->getQRurl($_GET['pid']));
   // $obj->logs('log.txt', '0');
}
//echo $obj->getQRurl('12334');
//$obj->checks();