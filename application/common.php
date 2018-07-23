<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
//图片处理
function my_scandir($dir = UEDIOOR){
    $files = array();
    $dir_list = scandir($dir);
    foreach ($dir_list as $file){
        if($file != '.' && $file != '..'){
            if(is_dir($dir.'/'.$file)){
                $files[$file] = my_scandir($dir.'/'.$file);
            }else{
                $files[] = $dir.'/'.$file;
            }
        }
    }
    return $files;
}

function dd($value){
    dump($value);
    die;
}