<?php
/**
 * 基础模型
 * User: @ 若雨
 * Date: 2018/7/14
 * Time: 17:05
 */

namespace app\admin\model;


use think\Model;
class BaseModel extends Model
{
    //自动时间戳
    protected $autoWriteTimestamp = true;
}