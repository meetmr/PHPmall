<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------
use app\admin\model\GoodsImg;
use app\admin\model\Category;
use app\admin\model\Product;
use app\admin\model\Recommend;
use  app\admin\model\Goods;

//图片处理
function my_scandir($dir = UEDIOOR){
    $files = array();
    $dir_list = scandir($dir);
    foreach ($dir_list as $file){
        if($file != '.' && $file != '..'){
            if(is_dir($dir.'/'.$file)){
                $files[$file] = my_scandir($dir.'/'.$file);
            }else{
                $files[] = $dir.'/'.$file;
            }
        }
    }
    return $files;
}

function dd($value){
    dump($value);
    die;
}

//订单号   产品编号
function get_shop()
{
    $yCode = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');
    return $yCode[intval(date('Y')) - 2018] . strtoupper(dechex(date('m'))) . date('d') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf('%02d', rand(0, 99));
}

// 传入商品id、获取商品相册
function getGoodsImg($goodsId){
    return GoodsImg::getGoodsImg($goodsId);
}

// 闯入分类id、获取商品分类名称
 function getGoodsCategoryName($c_id){
    return Category::getGoodsCategoryName($c_id);
}

// 传入商品ID 获取商品属性值
function getGoodsProduct($goods_id){
    return Product::getGoodsProduct($goods_id);
}

// 获取推荐位名称
function getGoodsRecommendName($c_id){
    return Recommend::getGoodsRecommendName($c_id);
}

// 字符截取替换

//字符串截取并且超出显示省略号

function subtext($text, $length){
    if (mb_strlen($text, 'utf8') > $length){
        return mb_substr($text, 0, $length, 'utf8') . ' …';
    }
    return $text;
}
// 传入商品ID 获取商品名称

function getGoodsName($goods_id){
    $goods_name = Goods::where(['id'=>$goods_id])->value('goods_name');
    return subtext($goods_name,50);
}
//订单号   产品编号
function get_order()
{
    $yCode = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J','O');
    return $yCode[intval(date('Y')) - 2012] . strtoupper(dechex(date('m'))) . date('d') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf('%02d', rand(0, 99));
}