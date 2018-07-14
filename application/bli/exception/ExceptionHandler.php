<?php
/**
 * 重写异常类
 * User: @若雨
 * Date: 2018/7/14
 * Time: 15:39
 */

namespace app\bli\exception;


use think\exception\Handle;
use think\facade\Request;
use think\facade\Log;
class ExceptionHandler extends Handle
{
    private $code;
    private $msg;
    private $errorCode;
    public function render(\Exception $e){
        if($e instanceof BaseException){
            $this->code = $e->code;
            $this->msg = $e->msg;
            $this->errorCode = $e->errorCode;
        }else{
            if(config('app_debug')){
                return parent::render($e);
            }else{
                $this->code = 500;
                $this->msg = '服务器内部错误';
                $this->errorCode = 999;
                $this->recordErrorLog($e);
            }

        }
        $result = [
            'msg'        => $this->msg,
            'errorCode'  => $this->errorCode,
            'requst_url' => Request::url()
        ];
        return json($result,$this->code);
    }

    private function recordErrorLog(\Exception $e){
        Log::init([
            'close' =>  false,
            'type'  =>  'File',
            'path'  =>  LOG_PATH,
            'level' =>  ['error'],
        ]);
        Log::record($e->getMessage(),'error');
    }
}