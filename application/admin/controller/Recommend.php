<?php
/**
 *推荐位控制器
 * User: @ 若雨
 * Date: 2018/9/14
 * Time: 14:24
 */

namespace app\admin\controller;

use app\admin\model\Recommend as RecommendModel;
use think\facade\Request;
class Recommend extends BaseController
{
    // 展示列表
    public function index(){
        $recommends = RecommendModel::order('id desc')->select();
        $this->assign([
            'recommends'    =>  $recommends
        ]);
        return $this->fetch('reco-info');
    }

    // 添加商品
    public function add(){
        if(Request::isAjax()){
            $data = Request::post();
            $info = RecommendModel::create($data);
            return $this->_return($info);
        }
        return $this->fetch('reco-add');
    }

    // 修改推荐位
    public function edit(){
        if(Request::isAjax()){
            $data = Request::post();
            $id = $data['id'];
            unset($data['id']);
            $info = RecommendModel::update($data,['id'=>$id]);
            return $this->_return($info);
        }
        $id = intval(input('id'));
        $recommend = RecommendModel::get($id);
        $this->assign([
            'recommend'    =>  $recommend
        ]);
        return $this->fetch('reco-edit');
    }
    public function delete(){
        if(Request::isAjax()){
            $id  = Request::post('id');
            $res = RecommendModel::where(['id'=>$id])->delete();
            return $this->__return($res);
        }
    }
}