<?php
/**
 * 推荐位模型
 * User: @ 若雨
 * Date: 2018/9/14
 * Time: 14:24
 */

namespace app\admin\model;


class Recommend extends BaseModel
{
    // 获取推荐位名称
    public static function getGoodsRecommendName($c_id){
        return self::where('id','=',$c_id)->value('name');
    }
}