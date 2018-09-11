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
    public function __return($info,$isimg = 0,$img_path = null){
        if($info){
            if($isimg){
                $path = './static/uploads/'.$img_path;
                if(file_exists($path)){
                    @unlink($path);
                }
            }
            return json(1);
        }else{
            return json(0);
        }
    }

    //传入又id和sort组成的输出$data。$model 为模型实例
    public function Sort($data,$model){
        //获取当然id的数据
        $Info = $model->where("id", "=", $data['id'])->field('id,sort')->find();
        $infoSort = $Info['sort'];
        if($data['sort'] == 'asc'){  //如果是上
            //获取上一条数据
            $ascInfo = $model->where("sort", "<", $infoSort)->field('id,sort')->order("sort", "desc")->find();
            if($ascInfo == null){ //如果没有数据 则是第一条数据
                return json([
                    'error' => 1000,
                    'msg'   =>  '已经是第一条数据'
                ]);
            }
            $ysort= $Info['sort'];
            $xsort = $ascInfo['sort'];
            //交换排序
            $info = $model->update(['sort'=>$ysort],['id'=> $ascInfo['id']]);
            $info1 = $model->update(['sort'=>$xsort],['id'=> $Info['id']]);
            if($info && $info1){
                return json([
                    'error' => 1,
                ]);
            }else{
                return json([
                    'error' => 0,
                    'msg'   =>  '排序失败'
                ]);
            }
        }else if($data['sort'] == 'desc'){
            $ascInfo = $model->where("sort", ">", $infoSort)->field('id,sort')->order("sort", "asc")->find();
            //如果是最后一条数据
            if($ascInfo == null){
                return json([
                    'error' => 1000,
                    'msg'   =>  '已经是最后一条数据'
                ]);
            }
            $ysort= $Info['sort'];
            $xsort = $ascInfo['sort'];
            //交换排序
            $info = $model->update(['sort'=>$ysort],['id'=> $ascInfo['id']]);
            $info1 = $model->update(['sort'=>$xsort],['id'=> $Info['id']]);
            if($info && $info1){
                return json([
                    'error' => 1,
                ]);
            }else{
                return json([
                    'error' => 0,
                    'msg'   =>  '排序失败'
                ]);
            }
        }
    }
}