<?php
 header("Content-Type: text/html; charset=UTF-8");
error_reporting(0);


	require_once "./lib/config.php";
    require_once "./lib/Log.class.php";
    require_once "./lib/Epay.class.php";  

    $EpayClient = new EpayClientAop($config);
    $LogClient  = new LogClientAop();

    /****接收对应参数通知****/
    $result = $EpayClient->acceptNotify($config);

    /****记录支付成功结果记录****/
    $LogClient->reply_log($result);

    /****将支付结果写到支付文件中方便提现SDK支付成功后的一个方法*****/
    $LogClient->success_log($result["out_trade_no"]);

    /***************
    *
    *
    * 执行您的业务逻辑
    *
    *
    *
    ****************/

    echo "success";exit;        //返回服务器已成功通知
 
?>