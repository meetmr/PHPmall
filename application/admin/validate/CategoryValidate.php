<?php
/**
 * 品牌验证器
 * User: @ 若雨
 * Date: 2018/7/14
 * Time: 16:54
 */

namespace app\admin\validate;


class CategoryValidate extends BaseValidate
{
    protected $rule = [
      'cate_name|分类标题'         =>'require|unique:category',
    ];

}