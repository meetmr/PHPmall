<?php
/**
 * 栏目控制器
 * User: @ 若雨
 * Date: 2018/7/15
 * Time: 8:29
 */

namespace app\admin\controller;

use app\admin\model\Cate as CateMode;
use app\admin\validate\CateValidate;
use catetree\Catetree;
use think\facade\Request;

class Cate extends BaseController
{
    //渲染列表
    public function index(){
        $cate = new Catetree();
        $cateInfo = CateMode::order('sort','asc')->select();
        $catelist =  $cate->catetree($cateInfo);
        $this->assign([
            'cateInfo'     =>$cateInfo,
            'catelist'   =>$catelist
        ]);
        return $this->fetch('cate-info');
    }
    //添加
    public function add(){
        if(Request::isAjax()){
            (new CateValidate())->goCheck();
            $data = Request::post();
            $info = CateMode::create($data);
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
        //获取到栏目列表
        $cateList = CateMode::select();
        $cate = new Catetree();
        $cateList =  $cate->catetree($cateList);
        $this->assign([
            'cateList'  =>  $cateList,
        ]);
        return $this->fetch('cate-add');
    }
    //修改操作
    public function edit(){
        if(Request::isAjax()){
            $data = Request::post();
            (new CateValidate())->goCheck();
            $id = $data['id'];
            unset($data['id']);
            $data['show_naw'] =isset($data['show_naw']) ? '1' : '0';
            $info = CateMode::update($data,['id'=>$id]);
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
        $cateRow =  CateMode::get($id);
        //获取到栏目列表
        $cateList = CateMode::select();
        $cate = new Catetree();
        $cateList =  $cate->catetree($cateList);
        $this->assign([
            'cateList'  =>  $cateList,
            'cateRow'   =>  $cateRow,
        ]);
        return $this->fetch('cate-edit');
    }
    //更改状态
    public function updateStatus(){
        if(Request::isAjax()){
            $data = Request::post();
            return $this->_updateState($data);
        }
    }

    //排序
    public function updateSort(){
        if(Request::isAjax()){
            $data = Request::post();
            return $this->_updateSort($data);
        }
    }
    public function delete(){
        if(Request::isAjax()){
            $id  = Request::post('id');
            $res = CateMode::where(['id'=>$id])->delete();
            if($res){
                return json(1);
            }else{
                return json(0);
            }
        }
    }
}