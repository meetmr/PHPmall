<?php
/**
 *  用户控制器
 * User: @ 若雨
 * Date: 2018/9/18
 * Time: 11:15
 */

namespace app\admin\model;


class User extends BaseModel
{
    protected $table = 'tp_users';

    // 传入用户名、验证用户名是否已注册
    public static function seeUserName($username){
        return self::where(['username' => $username])->select()->count() == true ? true : false;
    }

    // 传入邮箱、验证邮箱是否已注册
    public static function seeUserEmail($email){
        return self::where(['email'=>$email])->select()->count() == true ? true : false;
    }

    // 传入用户名密码 判断是否正确
    public static function loinUser($username,$password){
        return self::where(['username'=>$username])->where(['password'=>md5($password)])->find();
    }
}