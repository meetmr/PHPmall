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
Route::rule('category/:id','index/Categorys/index','GET',['ext'=>'html|htm'],['id'=>'\d{1,5}']);
// 栏目
Route::rule('column/:id','index/Column/index','GET',['ext'=>'html|htm'],['id'=>'\d{1,5}']);

//商品
Route::rule('goods/:id','index/Goods/index','GET',['ext'=>'html|htm'],['id'=>'\d{1,5}']);
