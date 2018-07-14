<?php
/**
 * 基础验证器
 * User: 王恒兵
 * Date: 2018/6/14
 * Time: 21:23
 */

namespace app\admin\validate;

use app\bli\exception\ParameterException;
use app\bli\exception\RarameterException;
use think\Validate;
use think\Facade\Request;
class BaseValidate extends Validate
{
    public function goCheck(){
        //获取http的参数
        //参数校验
        $params = Request::param();
        $result = $this->check($params);
        if(!$result){
            throw new ParameterException(['msg'=> $this->error]);
        }else{
            return true;
        }
    }
    //自定义验证规则
    protected function isPositiveInteger($value){
        if(is_numeric($value) && ($value + 0) > 0){
            return true;
        }else{
            return false;
        }
    }
    public function isNotEmpty($value){
        if(empty($value)){
            return false;
        }else{
            return true;
        }
    }
    public function getDateByRule($dateArray){
        if(array_key_exists('user_id',$dateArray) | array_key_exists('uid',$dateArray)){
            throw new RarameterException([
                'msg'   => '非法参数'
            ]);
        }
        $newArray = [];
        foreach ($this->rule as $key => $value) {
            $newArray[$key] = $dateArray[$key];
        }
        return $newArray;
    }

    protected function isMobile($value)
    {
        $rule = '^1(3|4|5|7|8)[0-9]\d{8}$^';
        $result = preg_match($rule, $value);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
}