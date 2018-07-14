<?php
/**
 * 基础控制
 * User: @若雨
 * Date: 2018/7/14
 * Time: 13:16
 */

namespace app\admin\controller;

use think\Controller;
use think\facade\Request;

class BaseController extends Controller
{
    public function upload(){
        $file = Request::file('file');
        $info = $file->validate(['ext'=>'jpg,png,gif'])->move( '../public/static/uploads');
        if($info){
            // 成功上传后 获取上传信息
            $finename= $info->getSaveName();
            return json([
                'code' =>1,
                'url' =>$finename,
            ]);
        }else{
            return json(['code' =>0,]);
        }
    }
}