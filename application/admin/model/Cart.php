<?php
/**
 *  购物车
 * User: @ 若雨
 * Date: 2018/9/20
 * Time: 10:02
 */

namespace app\admin\model;


use think\Model;

class Cart extends Model
{
    protected $table = 'tp_cart';

    public static function getCart(){
        // 获取当前用户的购物车
        $user_id = session('user.id');
        $userCart = self::where(['u_id'=>$user_id])->select();
        foreach ($userCart as $item){
            $item['goods'] = Goods::getGoodsInfo($item['g_id']);
        }
        $sum_price = 0;
        foreach ($userCart as $item){
            $sum_price += $item['number'] * $item['goods']['shop_price'];
        }
        $data['userCart'] = $userCart;
        $data['sum_price'] = $sum_price;
        return $data;
    }
}