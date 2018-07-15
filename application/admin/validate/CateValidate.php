<?php
/**
 * 栏目验证器
 * User: @ 若雨
 * Date: 2018/7/14
 * Time: 16:54
 */

namespace app\admin\validate;


class CateValidate extends BaseValidate
{
    protected $rule = [
      'cate_name|栏目名称'  =>'require|unique:cate',
    ];
}