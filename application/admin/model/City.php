<?php
/**
 *  城市
 * User: @ 若雨
 * Date: 2018/9/11
 * Time: 15:30
 */

namespace app\admin\model;
use think\Model;

class City extends Model{
    protected $table = 'city';
    public static function getCitylist($parent_id = 1){
        $data = [
            'parent_id' =>$parent_id ,
        ];
        return self::where($data)->select();
    }
    public static function getCityName($pr_id){
        return self::where(['region_id'=>$pr_id])->value('region_name');
    }
}