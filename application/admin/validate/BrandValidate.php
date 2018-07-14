<?php
/**
 * 品牌验证器
 * User: @ 若雨
 * Date: 2018/7/14
 * Time: 16:54
 */

namespace app\admin\validate;


class BrandValidate extends BaseValidate
{
    protected $rule = [
      'brand_name|品牌名称'  =>'require|unique:brand',
      'url|品牌地址'         =>'url'
    ];
    protected $message = [
        'brand_name|require'    =>  '品牌名称不能为空'
    ];
}