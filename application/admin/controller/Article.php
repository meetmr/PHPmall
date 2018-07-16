<?php
/**
 * 文章控制器
 * User: @ 若雨
 * Date: 2018/7/15
 * Time: 15:23
 */

namespace app\admin\controller;

use app\admin\model\Article as ArticleModel;
use app\admin\model\Cate as CateModel;
use app\admin\validate\ArticleValidate;
use think\facade\Request;
class Article extends BaseController
{
    //渲染列表
    public function index(){
        $articleInfo = ArticleModel::with('Cate')->select();
        $this->assign([
           'articleInfo'    =>  $articleInfo,
        ]);
        return $this->fetch('article-info');
    }
    //添加页面
    public function add(){
        if(Request::isAjax()){
            $data = Request::post();
            $data['show_naw']  = isset($data['show_naw']) ? '1' : '0';
            (new ArticleValidate())->goCheck();
            $info = ArticleModel::create($data);
            return $this->_return($info);
        }
        //查询栏目
        $cateList = CateModel::getCate();
        $this->assign('cate_list',$cateList);
        return $this->fetch('article-add');
    }
    //更改是否置顶
    public function updateTop(){
        if(Request::isAjax()){
            $data = Request::post();
            return $this->_updateState($data);
        }
    }
    //更改状态
    public function updateStatus(){
        if(Request::isAjax()){
            $data = Request::post();
            return $this->_updateState($data);
        }
    }

    //删除操作
    public function delete(){
        if(Request::isAjax()){
            $id  = Request::post('id');
            $img_path =  Request::post('img_path');
            $res = ArticleModel::where(['id'=>$id])->delete();
           return $this->__return($res,1,$img_path);
        }
    }

    //编辑操作
    public function edit(){
        if(Request::isAjax()){
            $data = Request::post();
            $id = $data['id'];
            unset($data['id']);
            $yauntu =  $data['yuantu'];
            unset($data['yuantu']);
            $data['show_top'] = isset($data['show_top']) ? '1' : '0';
            if($data['thumb']){
                $path = './static/uploads/'.$yauntu;
                if(file_exists($path)){
                    @unlink($path);
                }
            }else{
                unset($data['thumb']);
            }
            $info = ArticleModel::update($data,['id'=>$id]);
            return $this->_return($info);
        }
        $id = intval(input('id'));
        //查询栏目
        $Article = ArticleModel::get($id);
        $cateList = CateModel::getCate();
        $this->assign([
            'cate_list' => $cateList,
            'article'   => $Article,
        ]);
        return $this->fetch('article-edit');
    }
}