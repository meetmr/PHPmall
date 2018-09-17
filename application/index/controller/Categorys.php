<?php
/**
 * 分类
 * User: @ 若雨
 * Date: 2018/9/17
 * Time: 16:52
 */

namespace app\index\controller;

use app\admin\model\Category;
use app\admin\model\Goods;

class Categorys extends BaseController
{
    public function index($id){
        $Category = Category::getCategoryErJi(); //生成二级分类
        $goods = Goods::getCategoryGoods($id);
        $count = $goods->count();
        $this->assign([
            'category'  =>  $Category,
            'goods'     =>  $goods,
            'count'     =>  $count,
            'id'       =>  $id
        ]);
        return $this->fetch();
    }

}