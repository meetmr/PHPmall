<?php
namespace app\user\controller;

use think\Controller;
use app\admin\model\City as CityModel;
class City extends Controller{
    public function index(){
        $list_city = CityModel::getCitylist();
        $this->assign('list_city',$list_city);
        return $this->fetch();
    }
    public function getlevelcity(){
        $region_id = input('post.region_id');
        $listlevelcity = getCitylist($region_id);
        echo json_encode($listlevelcity);
    }
}