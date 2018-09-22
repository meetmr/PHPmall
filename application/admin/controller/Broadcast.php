<?php
/**
 *  轮播图控制器
 * User: @ 若雨
 * Date: 2018/9/21
 * Time: 14:27
 */

namespace app\admin\controller;

use think\facade\Request;
use app\admin\model\Goods;
use app\admin\model\Broadcast as BroadcastModel;
class Broadcast extends BaseController
{
    // 轮播图列表
    public function info(){
        $broadcasts = BroadcastModel::order('id desc')->select();
        $this->assign([
            'broadcasts' =>  $broadcasts
        ]);
        return $this->fetch();
    }
    // 添加轮播图
    public function add(){
        if(Request::isAjax()){
            $data = Request::post();
            unset($data['file']);
            $info =BroadcastModel::create($data);
            return $this->_return($info);
        }
        // 获取商品
        $goods = Goods::order('id desc')->field('id,goods_name')->select();
        $this->assign([
            'goods' =>  $goods
        ]);
        return $this->fetch();
    }

    // 修改轮播图
    public function edit(){
        if(Request::isAjax()){
            $data = Request::post();
            $id = $data['id'];
            unset($data['id']);
            unset($data['file']);
            $info = BroadcastModel::update($data,['id'=>$id]);
            return $this->_return($info);
        }
        $id = input('id');
        $broadcast = BroadcastModel::get($id);
        $goods = Goods::order('id desc')->field('id,goods_name')->select();
        $this->assign([
            'broadcast' =>  $broadcast,
            'goods'    =>  $goods
        ]);
        return $this->fetch();
    }

    public function delete(){
        if(Request::isAjax()){
            $id  = Request::post('id');
            $img_path =  Request::post('img_path');
            $res = BroadcastModel::where(['id'=>$id])->delete();
            return $this->__return($res,1,$img_path);
        }
    }
}