<?php
/**
 * 栏目模型
 * User: @ 若雨
 * Date: 2018/7/15
 * Time: 8:44
 */

namespace app\admin\model;


class Cate extends BaseModel
{
    protected $hidden = ['cate_keywords','cate_type','cate_description','show_naw','sort','pid','cate_admin','create_time','update_time'];

}