<?php
/**
 *  订单管理
 * User: @ 若雨
 * Date: 2018/9/28
 * Time: 14:16
 */

namespace app\admin\controller;

use app\admin\model\Order as OrderModel;

class Order extends BaseController
{
    public function info($status = 0){
        if($status == 0){
            $orders = OrderModel::order('id desc')->paginate(15);
        }else{
            $orders = OrderModel::order('id desc')->where(['status'=>$status])->paginate(15);
        }

        $this->assign([
            'orderss'   =>  $orders
        ]);
        return $this->fetch();
    }
    // 订单详情
    public function orderInfo($id){
        $order = OrderModel::where(['id'=>$id])->find();
        $this->assign([
            'order'   =>  $order
        ]);
        return $this->fetch('info-order');
    }
    public function updateState($id){
        $id = intval($id);
        $state = OrderModel::where(['id'=>$id])->value('status');
        $this->assign([
            'state' =>  $state
        ]);
        return $this->fetch('update-state');
    }
}