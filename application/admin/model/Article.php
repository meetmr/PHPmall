<?php
/**
 * 文章模型
 * User: @ 若雨
 * Date: 2018/7/15
 * Time: 15:30
 */

namespace app\admin\model;

use app\admin\model\Cate;
class Article extends BaseModel
{
    public function Cate()
    {
        return $this->belongsTo('Cate','cate_id','id');
    }

    //获取网点帮助分类
    public  function getFooterArts(){
        $Cate = new Cate();
        //获取网点帮助分类
        $helpCateRes = $Cate->where(['cate_type'=>3])->select();
        foreach ($helpCateRes as $k=>$v){
            $helpCateRes[$k]['arts'] = $this->where(['cate_id'=>$v['id']])->select();
        }
        return $helpCateRes;
    }
}