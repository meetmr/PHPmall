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
            return $this->_return($info);
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
            return $this->_return($info);
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
            $data = Request::post();
            return $this->_updateState($data);
        }
    }
    public function deleteBrand(){
        if(Request::isAjax()){
            $id  = Request::post('id');
            $img_path =  Request::post('img_path');
            $res = BrandModel::where(['id'=>$id])->delete();
            return $this->__return($res,1,$img_path);
        }
    }

    public function updateSort(){
        if(Request::isAjax()){
            $data = Request::post();
            return $this->_updateSort($data);
        }
    }

}