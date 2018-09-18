<?php
/**
 *  商品控制器
 * User: @ 若雨
 * Date: 2018/9/18
 * Time: 14:23
 */

namespace app\index\controller;

use app\admin\model\Goods as GoodesModel;
use think\facade\Request;
class Goods extends BaseController
{
    public function index($id){
        // 获取商品详细信息
        $goodsInfo = GoodesModel::getGoodsInfo($id);
        // 获取
        $this->assign([
            'goodsInfo' =>  $goodsInfo,
        ]);
        return $this->fetch();
    }

    // 传入商品id获取商品库存
    public function getGoodsStock(){
       $goods_id = Request::post('goods_id');
       return json(GoodesModel::getGoodsStock($goods_id));
    }
}