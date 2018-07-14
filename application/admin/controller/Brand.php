<?php
/**
 * 品牌控制器
 * User: @ 若雨
 * Date: 2018/7/14
 * Time: 16:08
 */

namespace app\admin\controller;


use app\admin\model\Brand as BrandModel;
use app\admin\validate\BrandValidate;
use think\facade\Request;
class Brand extends BaseController
{
    //品牌列表
    public function index(){
        //获取品牌列表
        $brandInfo = BrandModel::order('sort','asc')->paginate(10);
        $this->assign([
           'brandInfo'     =>  $brandInfo,
        ]);
        return $this->fetch('brand-info');
    }
    //添加品牌
    public function add(){
        if(Request::isAjax()){
            (new BrandValidate())->goCheck();
            $data = Request::post();
            $data['status'] =isset($data['status']) ? '1' : '0';
            $info =  BrandModel::create($data);
            if($info){
                return json([
                    'errorCode'=>1
                ]);
            }
        }
        return $this->fetch('brand-add');
    }
    //修改操作
    public function edit(){
        if(Request::isAjax()){
            $data = Request::post();
            $id = $data['id'];
            unset($data['id']);
            $yauntu =  $data['yuantu'];
            unset($data['yuantu']);
            $data['status'] =isset($data['status']) ? '1' : '0';
            if($data['brand_logo']){
                $path = './static/uploads/'.$yauntu;
                if(file_exists($path)){
                    @unlink($path);
                }
            }else{
                unset($data['brand_logo']);
            }
            $info = BrandModel::update($data,['id'=>$id]);
           if($info){
               return json([
                   'errorCode'=>1
               ]);
           }else{
               return json([
                   'errorCode'=>0
               ]);
           }
        }
        $id = intval(input('id'));
        $brandRow = BrandModel::get($id);
        $this->assign([
            'brandRow'  =>  $brandRow,
        ]);
        return $this->fetch('brand-edit');
    }
    public function updateStatus(){
        if(Request::isAjax()){
            $id  = Request::post('id');
            $status = 1 == Request::post('status')? 0 : 1;
            $res = BrandModel::update(['status'=>$status],['id'=>$id]);
            if($res){
                return json(1);
            }else{
                return json(0);
            }
        }
    }
    public function deleteBrand(){
        if(Request::isAjax()){
            $id  = Request::post('id');
            $img_path =  Request::post('img_path');
            $res = BrandModel::where(['id'=>$id])->delete();
            if($res){
                $path = './static/uploads/'.$img_path;
                if(file_exists($path)){
                    @unlink($path);
                }
                return json(1);
            }else{
                return json(0);
            }
        }
    }
    public function updateSort(){
        $id = intval(Request::post('id'));
        $sort = intval(Request::post('listorder'));
        $rew = BrandModel::update(['sort'=>$sort],['id'=>$id]);
        if($rew){
            return(1);
        }else{
            return(0);
        }
    }
}