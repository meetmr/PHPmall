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
}