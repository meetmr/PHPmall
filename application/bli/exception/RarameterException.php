<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/6/19
 * Time: 20:39
 */

namespace app\bli\exception;


class RarameterException extends BaseException
{
    public $code = 200;
    public $msg = '非法参数';
    public $errorCode = 999;
}