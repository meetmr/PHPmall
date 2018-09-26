<?php
include $payPlus.'Base.php';

class Notify extends Base
{
    public function __construct() {
        parent::__construct();

        //获取微信服务器提交过来的通知数据
        $xml = $this->getPost();
        //将XML格式的数据转换为数组
        $arr = $this->XmlToArr($xml);
        \think\Db::table('tp_order')->where(['order_id'=>$arr['out_trade_no']])->update(['status'=>10]);

        //验证签名
        if( $this->checkSign($arr)){
            \think\Db::table('tp_order')->where(['order_id'=>$arr['out_trade_no']])->update(['status'=>11]);

            //验证订单金额
            if($this->checkPrice($arr)){
                //更新订单状态
                  \think\Db::table('tp_order')->where(['order_id'=>$arr['out_trade_no']])->update(['status'=>2]);
                $this->logs('log.txt', '2');
                $params = [
                    'return_code'    => 'SUCCESS',
                    'return_msg'    => 'OK'
                ];
                echo $this->ArrToXml($params);
            }
        }
    }

    //校验订单金额 根据订单号$arr['out_trade_no'] 在商户系统内查询订单金额 并和$arr['total_fee']做比较
    public function checkPrice($arr){

        if($arr['return_code'] == 'SUCCESS' && $arr['result_code'] == 'SUCCESS'){
            $orderPayment = \think\Db::table('tp_order')->where(['order_id'=>$arr['out_trade_no']])->value('payment');
            $orderPayment = $orderPayment * 100;
            if($arr['total_fee'] == $orderPayment){//生产环境需要根据订单号在数据库中查询金额
                return true;
            }else{
                $this->logs('log.txt', '订单金额不匹配!微信支付系统提交过来的金额为' . $arr['total_fee']);
            }
        }else{
            $this->logs('log.txt', '通知状态有误!');
        }
    }
}
