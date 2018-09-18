<?php
/**
 * 商品分类模型模型
 * User: @ 若雨
 * Date: 2018/9/11
 * Time: 15:30
 */

namespace app\admin\model;

use catetree\Catetree;

class Category extends BaseModel
{
      public static function getInfoCategory(){
          $cate_list = self::order('sort asc')->select();
          $cate = new Catetree();
          $cateList = $cate->catetree($cate_list);
          return $cateList;
    }
    // 传入分类id、获取商品分类名称
   public static function getGoodsCategoryName($c_id){
          return self::where('id','=',$c_id)->value('cate_name');
    }

    // 生成商品分类
    public static function getCategory(){
          return self::where('pid','=',0)->field('id,cate_name')->select();
    }

    // 生成产品分类二级
    public static function getCategoryErJi(){
        $goods =  self::where('pid','=',0)->field('id,cate_name')->select();
        foreach ($goods as $good){
            $goodserji =  self::where('pid','=',$good['id'])->field('id,cate_name')->select();
            $good['erji'] = $goodserji;
        }
        return $goods;
    }
    // 传入分类id、获取商品分类名称
    public static function getGoodsCategoryInfo($c_id){
        return self::where('id','=',$c_id)->field('id,cate_name')->find();
    }

}