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
use catetree\Catetree;
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
        $cate_list = CateModel::order('sort','asc')->select();
        $cate = new Catetree();
        $cateList = $cate->catetree($cate_list);
        $this->assign('cate_list',$cateList);
        return $this->fetch('article-add');
    }
}