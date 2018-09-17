<?php
/**
 * 商品图片
 * User: @ 若雨
 * Date: 2018/7/29
 * Time: 17:32
 */

namespace app\admin\model;


class GoodsImg extends BaseModel
{
    protected $table = 'goods_img';

    // 传入商品id、获取商品相册
    public static function getGoodsImg($goodsId){
        return  self::where('goods_id','=',$goodsId)->select();
    }
}