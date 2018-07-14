<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/6/15
 * Time: 9:01
 */

namespace app\bli\exception;

class ParameterException extends BaseException
{
    public $code = 200;
    public $msg  = '参数错误';
    public $errorCode = 10000;
}