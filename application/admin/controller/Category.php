<?php
/**
 * 商品分类控制器
 * User: @ 若雨
 * Date: 2018/9/11
 * Time: 15:23
 */

namespace app\admin\controller;

use app\admin\model\Category as CategoryModel;
use think\facade\Request;
use app\admin\validate\CategoryValidate;
class Category extends BaseController
{
    //渲染列表
    public function index(){
        $category = CategoryModel::getInfoCategory();
        $this->assign([
            'category'    =>  $category,
        ]);
        return $this->fetch('category-info');
    }
    //添加页面
    public function add(){
        if(Request::isAjax()){
            $data = Request::post();
            $data['status']  = isset($data['status']) ? '1' : '0';
            $maxSort = CategoryModel::order('sort desc')->value('sort');
            $data['sort'] = ++$maxSort;
            (new CategoryValidate())->goCheck();
            $info = CategoryModel::create($data);
            return $this->_return($info);
        }
        //查询栏目
        $categoryList =  CategoryModel::getInfoCategory();
        $this->assign('categoryList',$categoryList);
        return $this->fetch('category-add');
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
            $res = CategoryModel::where(['id'=>$id])->delete();
            return $this->_return($res);
        }
    }

    //编辑操作
    public function edit(){
        if(Request::isAjax()){
            $data = Request::post();
            $id = $data['id'];
            unset($data['id']);
            $data['status'] = isset($data['status']) ? '1' : '0';
            $info = CategoryModel::update($data,['id'=>$id]);
            return $this->_return($info);
        }
        $id = intval(input('id'));
        //查询栏目
        $Category = CategoryModel::get($id);
        $CategoryList = CategoryModel::getInfoCategory();
        $this->assign([
            'Category' => $Category,
            'CategoryList'   => $CategoryList,
        ]);
        return $this->fetch('category-edit');
    }


    //@DrawingInternal 为当前数据表模型
    public function SanSort(){
        $data = Request::post();
        $CategoryModel = new CategoryModel();
        return $this->Sort($data,$CategoryModel);
    }
}