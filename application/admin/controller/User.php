<?php
/**
 * 会员中心
 * User: @ 若雨
 * Date: 2018/9/27
 * Time: 21:34
 */

namespace app\admin\controller;
use app\admin\model\UserAddress;
use app\admin\model\User as UserModel;
use think\facade\Request;
use app\admin\model\Order;
class User extends BaseController
{
    public function info(){
        $users = UserModel::order('id desc')->select();
        $this->assign([
            'users'    =>   $users
        ]);
        return $this->fetch();
    }
    // 收获地址
    public function address($id){
        $userAddress = UserAddress::where(['user_id'=>$id])->select();
        $this->assign([
            'userAddress'    =>   $userAddress
        ]);
        return $this->fetch();
    }
    public function order($id){
        $orders = Order::where(['user_id'=>$id])->select();
        $this->assign([
            'orders'    =>   $orders
        ]);
        return $this->fetch();
    }
}