<?php
/**
 * 文章模型
 * User: @ 若雨
 * Date: 2018/7/15
 * Time: 15:30
 */

namespace app\admin\model;


class Article extends BaseModel
{
    public function Cate()
    {
        return $this->belongsTo('Cate','cate_id','id');
    }
}