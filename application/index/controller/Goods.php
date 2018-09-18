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
use app\admin\model\Category;
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

    // 搜索
    public function search($key=''){
        $Category = Category::getCategoryErJi(); //生成二级分类
        $goodsInfo = GoodesModel::getKeyGoodsInfo($key);
        $count = $goodsInfo->count();
        $id = 0;
        $this->assign([
            'category'  =>  $Category,
            'goods'     =>  $goodsInfo,
            'count'     =>  $count,
            'id'        =>  $id,
            'title'     =>  '搜索 '.$key
        ]);
        return $this->fetch();
    }
}