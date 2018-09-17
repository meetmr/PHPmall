<?php
namespace app\index\controller;

use app\admin\model\Goods;
class Index extends BaseController
{
    public function index()
    {
        //    获取最新商品
        $newGoods = self::getNewGoods();
        $countGoods = self::getGoods(20);
        $this->assign([
            'newGoods'      =>  $newGoods,   //    获取最新商品
            'countGoods'   =>  $countGoods
        ]);
        return $this->fetch();
    }

//    获取最新商品
    public static function getNewGoods(){
        return (Goods::getNewGoods());
    }

    // 获取指定数目商品
    public static function getGoods($count){
       return Goods::getGoods($count);
    }
}
