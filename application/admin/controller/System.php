<?php
/**
 * 系统管里控制器
 * User: @ 若雨
 * Date: 2018/7/16
 * Time: 15:36
 */

namespace app\admin\controller;

use think\facade\Request;
class System extends BaseController
{
    //图片列表
    public function imgList(){
        define('UEDIOOR',__DIR__.'/../../../public/ueditor/upload/image');
        $image_list = my_scandir(UEDIOOR);
        $imgList = [];
        foreach ($image_list as $k=>$v){
            foreach ($v as $v1){
                $imgList[] = $v1;
            }
        }
        $url = Request::domain();
        $this->assign('imgList',$imgList);
        $this->assign('url',$url);
        return $this->fetch('img-list');
    }
    //删除图片
    public function imgDelete(){
        $imgPath = Request::post('img');
        if(file_exists($imgPath)){
            if(@unlink($imgPath)){
                return json(1);
            }else{
                return json(0);
            }
        }else{
            return json(0);
        }
    }
}