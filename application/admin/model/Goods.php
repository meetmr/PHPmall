<?php
/**
 * 商品模型
 * User: @ 若雨
 * Date: 2018/7/15
 * Time: 15:30
 */

namespace app\admin\model;


use think\facade\Request;
use app\admin\model\Product;
use app\admin\model\GoodsImg;
use catetree\Catetree;
use app\admin\model\Category;
class Goods extends BaseModel
{
    protected  $field = true;
    // 模型构造函数

    protected static function init()
    {
        // 数据插入之后
      self::afterInsert(function ($goods) {
          // 获取插入之后的商品ID
          $goods_id = $goods['id'];
          $data = Request::post();
          // 处理商品属性
          $datakeyName = [];
          if(!empty($data['keyName'])){
              $keyName = $data['keyName'];
              foreach($keyName as $item){
                  $item1 = explode(",", $item);
                  $datakeyName['name'] = $item1[0];
                  $datakeyName['detail'] = $item1[1];
                  $datakeyName['goods_id'] = $goods_id;
                  Product::create($datakeyName);
              }
          }

          // 处理商品照片
          $datapc_src = $data['pc_src'];
          foreach ($datapc_src as $item){
              $datapcSrc['img_path'] = $item;
              $datapcSrc['goods_id'] = $goods_id;
              GoodsImg::create($datapcSrc);
          }
      });

      // 更新数据之前执行
        self::beforeUpdate(function ($goods) {
            $data = Request::post();
            // 获取商品id
            $goodsId = $data['id'];
            // 处理商品属性
            // 1、将原有的商品属性删除
            Product::where(['goods_id'=>$goodsId])->delete();
            // 2、重新入库
            if(!empty($data['keyName'])){
                $keyName = $data['keyName'];
                $datakeyName = [];
                foreach($keyName as $item){
                    $item1 = explode(",", $item);
                    $datakeyName['name'] = $item1[0];
                    $datakeyName['detail'] = $item1[1];
                    $datakeyName['goods_id'] = $goodsId;
                    Product::create($datakeyName);
                }
            }

            if(!empty($data['pc_src'])){
                // 处理商品图片
                // 1、获取原有的商品图片将其删除。
                $goodsImg = getGoodsImg($goodsId);
//                foreach ($goodsImg as $item){
//                    @unlink('./'.$item['img_path']);
//                }
                // 2、从数据库中、删除对应的数据
                GoodsImg::where(['goods_id'=>$goodsId])->delete();
                // 3、重新入库
                // 处理商品照片
                $datapc_src = $data['pc_src'];
                foreach ($datapc_src as $item){
                    $datapcSrc['img_path'] = $item;
                    $datapcSrc['goods_id'] = $goodsId;
                    GoodsImg::create($datapcSrc);
                }
            }
        });
    }

    // 获取最新商品
    public static function getNewGoods(){
        return self::where(['recommend_id'=>9])->where(['on_sale'=>1])->where(['is_delete'=>1])->field('id,goods_name,og_thumb')->limit(3)->select();
    }

    // 获取指定数目商品
    public static function getGoods($count){
       $goods =  self::where(['recommend_id'=>0])->where(['on_sale'=>1])->where(['is_delete'=>1])->field('id,goods_name,og_thumb,shop_price')->limit($count)->select();
        foreach ($goods as $item) {
            $ims = getGoodsImg($item['id']);
            $item['images'] = $ims;
            // 查询商品相册
        }
        return $goods;
    }

    // 跟据分类ID 查询分类下面的商品
    public static function getCategoryGoods($c_id = 0){
        // 0 表示所有的商品
        if($c_id == 0){
            $goods = self::where(['on_sale'=>1])->where(['is_delete'=>1])->field('id,goods_name,og_thumb,shop_price')->select();
            foreach ($goods as $item) {
                $ims = getGoodsImg($item['id']);
                $item['images'] = $ims;
                // 查询商品相册
            }
            return $goods;
        }else{
            // 获取二级分类
            $catetree = new Catetree();
            $Category = new Category();
            $ids = $catetree->childrenids($c_id,$Category);
            $ids[] = $c_id;
            $goods = self::where(['on_sale'=>1])->where(['is_delete'=>1])->where('category_id','in',$ids)->field('id,goods_name,og_thumb,shop_price')->select();
            foreach ($goods as $item) {
                $ims = getGoodsImg($item['id']);
                $item['images'] = $ims;
                // 查询商品相册
            }
            return $goods;
        }
    }
}