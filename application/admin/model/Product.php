<?php
/**
 * 商品属性
 * User: @ 若雨
 * Date: 2018/9/16
 * Time: 22:04
 */

namespace app\admin\model;


use think\Model;

class Product extends Model
{
    protected $table = 'product_property';

    // 传入商品ID 获取商品属性值
    public static function getGoodsProduct($goods_id){
        return self::where(['goods_id'=>$goods_id])->select();
    }
}