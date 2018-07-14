<?php
namespace app\admin\controller;

class Index extends BaseController
{
    //后台主页视图
    public function index()
    {
        return $this->fetch();
    }
    public function welcome(){
        return $this->fetch();
    }
}
