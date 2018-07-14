<?php
/**
 * Created by PhpStorm.
 * User: SYSTEM
 * Date: 2018/7/14
 * Time: 15:50
 */

namespace app\bli\exception;


class Cs extends BaseException
{
    // http 状态码
    public $code = 400;
    // 错误信息
    public $msg = '参数错误';
    // 自定义错误代码
    public $errorCode = 10000;
}