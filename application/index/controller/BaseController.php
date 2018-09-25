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
use app\admin\model\Cart as CartModel;
use app\admin\model\Broadcast;
use app\admin\model\Order;
class BaseController extends Controller
{
    public function initialize()
    {
        $this->getConf();
        $this->getRecommendColumn();
        $this->getCategory();
        $this->getFooterArts();
        $this->key();
        $this->getCartCount();
        $this->getBroadcast();
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

    // 搜索关键字显示
    public function key(){
        $conf = Conf::getConf();
        $confKey = explode(',',$conf['shousou']);
        $this->assign([
            'confKey'   =>  $confKey
        ]);
    }
    // 判断是否登陆
    public function isLogin(){
        if(!session('user')){
            return $this->redirect('user/login/login');
        }
    }

    //获取购物车数量
    public function getCartCount(){
        if(!session('user')){
            $this->assign([
                'cart_count'    =>0
            ]);
        }
        $user_id = session('user.id');
        $count =  CartModel::where(['u_id'=>$user_id])->select()->count();
        $this->assign([
            'cart_count'    =>$count
        ]);
    }

    // 获取轮播图
    public function getBroadcast(){
        $roadcast = Broadcast::order('id desc')->select();
        $this->assign([
            'roadcast' =>  $roadcast
        ]);
    }

    // 获取订单
    public function getOrder(){
        $order = Order::where(['user_id'=>session('user.id')])->select();
        return $order;
    }
}