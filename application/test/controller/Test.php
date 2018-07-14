<?php
namespace app\test\controller;
class Test{
    public function index(){
        return 'ok';
    }
    public function demo($name){
        return $name;
    }
}