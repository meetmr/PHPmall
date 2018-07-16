<?php
/**
 * 栏目模型
 * User: @ 若雨
 * Date: 2018/7/15
 * Time: 8:44
 */

namespace app\admin\model;

use catetree\Catetree;

class Cate extends BaseModel
{
    protected $hidden = ['cate_keywords','cate_type','cate_description','show_naw','sort','pid','cate_admin','create_time','update_time'];

    //获取栏目
    public static function getCate(){
        $cate_list = self::select();
        $cate = new Catetree();
        $cateList = $cate->catetree($cate_list);
        return $cateList;
    }
}