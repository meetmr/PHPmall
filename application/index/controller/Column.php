<?php
/**
 * 看栏目
 * User: @ 若雨
 * Date: 2018/9/17
 * Time: 19:05
 */

namespace app\index\controller;

use app\admin\model\Recommend;
use app\admin\model\Goods;

class Column extends BaseController
{
    public function index($id){
        // 获取栏目名称
       $column = Recommend::get($id);
       // 获取栏目下的商品
        $goods = Goods::getCategoryColumnGoods($id);
        $count = $goods->count();
        $this->assign([
            'column'    =>  $column,
            'goods'     =>  $goods,
            'count'     =>  $count
        ]);
        return $this->fetch();
    }
}