<?php
/**
 *  友情链接
 * User: @ 若雨
 * Date: 2018/7/23
 * Time: 11:13
 */

namespace app\admin\controller;

use app\admin\model\Link as LinkModel;
use think\facade\Request;
use app\admin\validate\LinkValidate;
class Link extends BaseController
{
    //渲染友情链接
    public function index(){
        $linkInfo = LinkModel::paginate(10);
        $this->assign([
            'linkInfo'  =>  $linkInfo
        ]);
        return $this->fetch('link-info');
    }
    //添加友链
    public function add(){
        if(Request::isAjax()){
            (new LinkValidate())->goCheck();
            $data = Request::post();
            unset($data['file']);
            $info =  LinkModel::create($data);
            return $this->_return($info);
        }
        return $this->fetch('link-add');
    }
    //编辑
    public function edit(){
        if(Request::isAjax()){
            $data = Request::post();
            $id = $data['id'];
            unset($data['id']);
            $yauntu =  $data['yuantu'];
            unset($data['yuantu']);
            if($data['logo']){
                $path = './static/uploads/'.$yauntu;
                if(file_exists($path)){
                    @unlink($path);
                }
            }else{
                unset($data['logo']);
            }
            $info = LinkModel::update($data,['id'=>$id]);
            return $this->_return($info);
        }
        $id = intval(input('id'));
        $LinkRow = LinkModel::get($id);
        $this->assign([
            'LinkRow'  =>  $LinkRow,
        ]);
        return $this->fetch('link-edit');
    }
    //更改状态
    public function updateStatus(){
        if(Request::isAjax()){
            $data = Request::post();
            return $this->_updateState($data);
        }
    }
    //删除
    public function deleteLink(){
        if(Request::isAjax()){
            $id  = Request::post('id');
            $img_path =  Request::post('logo');
            $res = LinkModel::where(['id'=>$id])->delete();
            return $this->__return($res,1,$img_path);
        }
    }
}