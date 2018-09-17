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
          $keyName = $data['keyName'];
          $datakeyName = [];
          foreach($keyName as $item){
              $item1 = explode(",", $item);
              $datakeyName['name'] = $item1[0];
              $datakeyName['detail'] = $item1[1];
              $datakeyName['goods_id'] = $goods_id;
              Product::create($datakeyName);
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
            $keyName = $data['keyName'];
            $datakeyName = [];
            foreach($keyName as $item){
                $item1 = explode(",", $item);
                $datakeyName['name'] = $item1[0];
                $datakeyName['detail'] = $item1[1];
                $datakeyName['goods_id'] = $goodsId;
                Product::create($datakeyName);
            }
            if($data['pc_src']){
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
}