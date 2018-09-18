<?php
/**
 * 前台基础控制器
 * User: @ 若雨
 * Date: 2018/9/17
 * Time: 15:02
 */

namespace app\index\controller;


use think\Controller;
use app\admin\model\Conf;
use app\admin\model\Recommend;
use app\admin\model\Category;
use app\admin\model\Article;
class BaseController extends Controller
{
    public function initialize()
    {
        $this->getConf();
        $this->getRecommendColumn();
        $this->getCategory();
        $this->getFooterArts();
    }

    // 获取配置信息
    public function getConf(){
        $conf = Conf::getConf();
        $this->assign([
            'confRes'   =>  $conf
        ]);
    }

    // 获取栏目推荐位
    public function getRecommendColumn(){
        $recommend = Recommend::getRecommendColumn();
        $this->assign([
            'recommend'   =>  $recommend
        ]);
    }

    // 获取商品分类
    public  function getCategory(){
        $category = Category::getCategory();
        $this->assign([
            'category'   =>  $category
        ]);
    }

    //获取帮助信息
    public function getFooterArts(){
        $Article = new Article();
        $helpCateRes = $Article->getFooterArts();
        $this->assign([
            'helpCateRes'   =>  $helpCateRes
        ]);
    }
}