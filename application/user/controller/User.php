<?php
/**
 *  用户控制器
 * User: @ 若雨PhpSt
 * Date: 2018/9/18
 * Time: 20:22
 */

namespace app\user\controller;


class User extends BaseController
{
    // 展示个人中心
    public function member(){
        return $this->fetch();
    }
}