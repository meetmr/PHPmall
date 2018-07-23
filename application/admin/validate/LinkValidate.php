<?php
/**
 * 友情链接验证器
 * User: @ 若雨
 * Date: 2018/7/14
 * Time: 16:54
 */

namespace app\admin\validate;


class LinkValidate extends BaseValidate
{
    protected $rule = [
      'title|链接标题'  =>'require|unique:link',
      'link_url|链接地址'         =>'url'
    ];
    protected $message = [
        'brand_name|require'    =>  '品牌名称不能为空'
    ];
}