<?php
/**
 * 配置验证器
 * User: @ 若雨
 * Date: 2018/7/29
 * Time: 16:54
 */

namespace app\admin\validate;


class ConfValidate extends BaseValidate
{
    protected $rule = [
        'cname|中文名称'  =>'require|unique:conf',
        'ename|英文名称'  =>'require|unique:conf',
    ];
}