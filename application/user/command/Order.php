<?php
namespace app\user\command;

use think\console\Command;
use think\console\Input;
use think\console\Output;
use app\admin\model\Order as OrderModel;
use app\admin\model\Goods;
use think\Db;

class Order extends Command
{
    protected function configure(){
        $this->setName('Order')->setDescription("计划任务");
    }

    protected function execute(Input $input, Output $output){
        $output->writeln('自动任务 start...');
        /*** START ***/
        $this->order();
        /*** END ***/
        $output->writeln('自动任务 end...');
    }

    /*
     * 1、 检测是否有过期订单
     * 2、 回退商品库存量
     * 3、 更改订单状态
     *
     * **/
    private function order(){
        while (true){ // 长期执行
            $currentTime = time();  // 当前时间
            $orders = OrderModel::where('close_time','<',$currentTime)->where(['status'=>1])->select();  // 获取未支付的过期订单
            // 回退库存量
            foreach ($orders as $order){
                $goods_item = json_decode($order['goods_item']);
                foreach ($goods_item as $item){
                    $stock = Goods::where(['id'=>$item->g_id])->value('stock');
                    $stock += $item->number;
                    Db::table('tp_goods')->where(['id'=>$item->g_id])->update(['stock'=>$stock]);
                }
                // 修改订单状态
                Db::table('tp_order')->where(['id'=>$order['id']])->update(['status'=>6]);
            }
            sleep(1);  //休眠1秒后再次执行
        }

    }
}