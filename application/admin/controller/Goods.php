<?php
/**
 * 商品控制器
 * User: @ 若雨
 * Date: 2018/9/14
 * Time: 15:07
 */

namespace app\admin\controller;

use app\admin\model\Goods as GoodesMdel;
use think\facade\Request;
use app\admin\model\Recommend;
use app\admin\model\Category;
class Goods extends BaseController
{
//    后台展示例表
    public function index(){
        // 获取商品列表
        $goods = GoodesMdel::order('id desc')->where('is_delete','=','1')->paginate(10);
        $this->assign([
            'goods'       =>   $goods
        ]);
        return $this->fetch('goods-info');
    }

    //添加商品
    public function add(){
        if(Request::isAjax()){
            $data = Request::post();
            // 构造商品基础信息数据
            $baseDate['goods_name'] = $data['goods_name'];
            $baseDate['goods_code'] = $data['goods_code'];
            $baseDate['og_thumb'] = $data['og_thumb'];
            $baseDate['markte_price'] = $data['markte_price'];
            $baseDate['shop_price'] = $data['shop_price'];
            $baseDate['on_sale'] = $data['on_sale'];
            $baseDate['category_id'] = $data['category_id'];
            $baseDate['goods_des'] = $data['content'];
            $baseDate['stock'] = $data['stock'];
            $baseDate['recommend_id'] = $data['recommend_id'];

            // 通过钩子方法对其他数据入库
            $info = GoodesMdel::create($baseDate);
            return $this->_return($info);

        }
        // 找出推荐位
        $recommends = Recommend::order('id desc')->select();
        // 获取商品分类数据
        $categorys = Category::getInfoCategory();
        //生成产品编号
        $googds_code = get_shop();
        $this->assign([
            'recommends'   =>   $recommends,
            'categorys'    =>   $categorys,
            'googds_code' =>   $googds_code
        ]);
        return $this->fetch('goods-add');
    }

    //通用缩略图上传接口
    public function upload1()
    {
        if($this->request->isPost()){
            $res['code']=1;
            $res['msg'] = '上传成功！';
            $file = $this->request->file('file');
            $info = $file->move('../public/upload/admin/');
            //halt( $info);
            if($info){
                $res['name'] = $info->getFilename();
                $res['filepath'] = 'upload/admin/'.$info->getSaveName();
            }else{
                $res['code'] = 0;
                $res['msg'] = '上传失败！'.$file->getError();
            }
            return $res;
        }
    }

    //添加
    public function add1()
    {
        if(request()->isPost())
        {
            //dump(input('post.')); layui-show
            $res = $this->tianjia(input('post.'));
            if($res['valid'])
            {
                $this->success($res['msg']);
            }else{
                $this->error($res['msg']);
            }
        }
        return $this->fetch();
    }

//添加
    public function tianjia($data)
    {
        //halt($data);
        $count = count($data['pc_src']);//获取传过来有几张图片
        if($count){
            for($i = 0;$i< $count;$i++){
                $data['pics'][]=array("src"=>$data['pc_src'][$i]);
            }
            $data['pics'] = json_encode($data['pics']);
            //$data['cc'] = json_decode($data['bb']);
            //halt($data);
        }

        $result = $this->validate(true)->allowField(true)->save($data);
        if($result){
            // 验证失败 输出错误信息
            return ['valid'=>1,'msg'=>'添加成功'];
            //dump($this->getError());
        }else{
            return ['valid'=>0,'msg'=>$this->getError()];
        }
    }

    //更改状态
    public function updateStatus(){
        if(Request::isAjax()){
            $data = Request::post();
            return $this->_updateState($data);
        }
    }

    // 删除操作
    public function delete(){
        if(Request::isAjax()){
            $id  = Request::post('id');
            $res = GoodesMdel::update(['is_delete'=>0],['id'=>$id]);
            return $this->__return($res);
        }
    }

    // 商品编辑操作
    public function editGoods(){
        if(Request::isAjax()){
            $data = Request::post();
            // 构造商品基础信息数据
            // 获取id
            $goodId = $data['id'];
            $baseDate['goods_name'] = $data['goods_name'];
            $baseDate['goods_code'] = $data['goods_code'];
            $baseDate['og_thumb'] = $data['og_thumb'];
            $baseDate['markte_price'] = $data['markte_price'];
            $baseDate['shop_price'] = $data['shop_price'];
            $baseDate['on_sale'] = $data['on_sale'];
            $baseDate['category_id'] = $data['category_id'];
            $baseDate['goods_des'] = $data['content'];
            $baseDate['stock'] = $data['stock'];
            $baseDate['recommend_id'] = $data['recommend_id'];
            $info = GoodesMdel::update($baseDate,['id'=>$goodId]);
            return $this->_return($info);


        }
        // 获取当前商品信息
        $goodsRow = GoodesMdel::get(input('id'));
        // 找出推荐位
        $recommends = Recommend::order('id desc')->select();
        // 获取商品分类数据
        $categorys = Category::getInfoCategory();
        // 获取商品属性值
        $goodsProduct = getGoodsProduct(input('id'));
        // 获取商品相册
        $goodsImg = getGoodsImg(input('id'));
        $this->assign([
            'recommends'    =>   $recommends,
            'categorys'     =>   $categorys,
            'goodsRow'      =>   $goodsRow,
            'goodsProduct'  =>    $goodsProduct,
            'goodsImg'     =>   $goodsImg
        ]);
        return $this->fetch('goods-edit');
    }
}