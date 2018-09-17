<?php
/**
 * 配置表模型
 * User: @ 若雨
 * Date: 2018/7/29
 * Time: 17:32
 */

namespace app\admin\model;


class Conf extends BaseModel
{
//    获取配置项
    public static function getConf(){
        $_congRes =  self::select();
        $congRes = [];
        foreach ($_congRes as $k=>$v){
            $congRes[$v['ename']] = $v['value'];
        }
        return $congRes;
    }
}