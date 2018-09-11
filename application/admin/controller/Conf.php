<?php
/**
 * 配置项控制器
 * User: @ 若雨
 * Date: 2018/7/26
 * Time: 19:28
 */

namespace app\admin\controller;

use think\facade\Request;
use app\admin\validate\ConfValidate;
use app\admin\model\Conf as ConfModel;
class Conf extends BaseController
{
    public function confList(){
        if(Request::isPost()){
            $data = Request::post();
            unset($data['file']);

            //复选框空选问题
            $chec_felds2d = ConfModel::field('ename')->where(['form_type'=>'checkbox'])->select();
            $chec_felds1d = [];
            if($chec_felds2d){
                foreach ($chec_felds2d as $k=>$v){
                    $chec_felds1d[] = $v['ename'];
                }
            }
            $all_fieds = [];
            //处理文字数据
            foreach ($data as $k=>$v){
                $all_fieds[] = $k;
                if(is_array($v)){
                    $value = implode(',',$v);
                    ConfModel::where(['ename'=>$k])->update(['value'=>$value]);
                }else{
                    ConfModel::where(['ename'=>$k])->update(['value'=>$v]);
                }
            }
            foreach ($chec_felds1d as $k=>$v){
                if(!in_array($v,$all_fieds)){
                    ConfModel::where(['ename'=>$v])->update(['value'=>'']);
                }
            }
            return $this->_return(1);
        }
        $shopConRows = ConfModel::where(['conf_type'=>1])->order('sort desc')->select();
        $goodsConRows = ConfModel::where(['conf_type'=>2])->order('sort desc')->select();
        $this->assign([
            'shopConRows'   =>  $shopConRows,
            'goodsConRows'  =>  $goodsConRows

        ]);
        return $this->fetch('conf-list');
    }
    //渲染列表
    public function index(){
        $confInfo = ConfModel::order('sort asc')->paginate(10);
        $this->assign([
            'confInfo'  =>  $confInfo
        ]);
        return $this->fetch('conf-info');
    }
    //添加操作
    public function add(){
        if(Request::isAjax()){
            $data = Request::post();
            if($data['form_type'] == 'radio' || $data['form_type'] == 'select' || $data['form_type'] == 'checkbox'){
                $data['values'] = str_replace('，',',',$data['values']);
                $data['value'] = str_replace('，',',',$data['value']);
            }
            (new ConfValidate)->goCheck();
            //执行入库操作
            $info = ConfModel::create($data);
            return $this->_return($info);
        }
        return $this->fetch('conf-add');
    }
    public function edit(){
        if(Request::isPost()){
            $data = Request::post();
            $id = intval($data['id']);
            unset($data['id']);
            if($data['form_type'] == 'radio' || $data['form_type'] == 'select' || $data['form_type'] == 'checkbox'){
                $data['values'] = str_replace('，',',',$data['values']);
                $data['value'] = str_replace('，',',',$data['value']);
            }
            $info = ConfModel::update($data,['id'=>$id]);
            return $this->_return($info);
        }
        $id = intval(input('id'));
        $confRow = ConfModel::get($id);
        $this->assign([
            'confRow'  =>  $confRow
        ]);
        return $this->fetch('conf-edit');
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
            $res = ConfModel::where(['id'=>$id])->delete();
            return $this->__return($res);
        }
    }
}