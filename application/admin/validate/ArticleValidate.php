<?php
/**
 * 品牌验证器
 * User: @ 若雨
 * Date: 2018/7/14
 * Time: 16:54
 */

namespace app\admin\validate;


class ArticleValidate extends BaseValidate
{
    protected $rule = [
      'cate_id|栏目'           =>'require',
      'title|文章标题'         =>'require|unique:article',
      'content|文章内容'       =>'require',
      'email|邮箱'             =>'email',
      'link_url|链接地址'       =>'url'
    ];

}