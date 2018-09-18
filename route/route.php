<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 分类
Route::get('category/:id','index/Categorys/index',['ext'=>'html|htm'],['id'=>'\d{1,5}']);
// 栏目
Route::get('column/:id','index/Column/index',['ext'=>'html|htm'],['id'=>'\d{1,5}']);

//商品
Route::get('goods/:id','index/Goods/index',['ext'=>'html|htm'],['id'=>'\d{1,5}']);

// 搜索
Route::get('search','index/Goods/search',['ext'=>'html|htm']);

// 用户注册
Route::get('reg','user/Login/register',['ext'=>'html|htm']);
// 用户登陆
Route::get('login','user/Login/login',['ext'=>'html|htm']);
