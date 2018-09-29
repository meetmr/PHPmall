<?php
header('Content-Type:text/html;charset=utf-8');
/**
 * Created by PhpStorm.
 * User: @ 若雨
 * Date: 2018/9/28
 * Time: 15:14
 */

$i = file_get_contents('http://www.kuaidi100.com/query?type=yunda&postid=3101775486667');
echo "<pre>";
print_r(json_decode($i));