<?php
/**
 * 基础控制
 * User: @若雨
 * Date: 2018/7/14
 * Time: 13:16
 */

namespace app\admin\controller;

use think\Controller;
use think\Db;
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
    /**
     * @table  表名
     * @value  字段名
     * */
    public function _updateState($data){
        $id  = $data['id'];
        $status = 1 == $data['status']? 0 : 1;
        $value = $data['value'];
        $res = db($data['table'])->where(['id'=>$id])->update([$value=>$status]);
        if($res){
            return json(1);
        }else{
            return json(0);
        }
    }

    //排序
    public function _updateSort($data){
        $id = intval($data['id']);
        $sort = intval($data['listorder']);
        $rew = db($data['table'])->where(['id'=>$id])->update([$data['value']=>$sort]);
        if($rew){
            return(1);
        }else{
            return(0);
        }
    }

    public function _return($info){
        if($info){
            return json([
                'errorCode'=>1
            ]);
        }else{
            return json([
                'errorCode'=>1
            ]);
        }
    }
    public function __return($info){
        if($info){
            return json(1);
        }else{
            return json(0);
        }
    }
}