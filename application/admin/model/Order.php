<?php
/**
 *  用户控制器
 * User: @ 若雨
 * Date: 2018/9/18
 * Time: 11:15
 */

namespace app\admin\model;
use app\admin\model\Goods;
use think\Db;

class Order extends BaseModel
{
    protected $table = 'tp_order';

    // 传入用户名、验证用户名是否已注册
    protected static function init()
    {
        // 数据插入之后
        self::afterInsert(function ($goods) {
            $user_id = session('user.id');
            $userCart = Cart::where(['u_id'=>$user_id])->select();
            // 减少库存量
            foreach ($userCart as $item){
                // 获取原有的库存
                $stock = Goods::where(['id'=>$item['g_id']])->value('stock');
                $stock = $stock-$item['number'];
                Db::table('tp_goods')->where(['id'=>$item['g_id']])->update(['stock'=>$stock]);
            }
        });
    }

}