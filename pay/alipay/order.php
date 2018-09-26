<?php
 
 error_reporting(E_ALL & ~E_NOTICE);

  if(isset($_POST["order_log"]))
  {
      require_once "./lib/config.php";
      require_once "./lib/Epay.class.php";  
      require_once "./lib/Log.class.php";

      $EpayClient = new EpayClientAop($config);
      $LogClient  = new LogClientAop();

      /****设置订单号****/
      $EpayClient->setOutTradeNo($_POST["order_sn"]);

      /****设置请求网关****/
      $EpayClient->setWayUrl("https://www.payonline.xin/order_log.request");

      /****记录所有发出参数****/
      $data = $EpayClient->getAllparam();
      
      $LogClient->request_log($data);

      /****发送请求获取订单信息****/
      $result = json_decode($EpayClient->order_log());

  } 
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Epay 交易支付SDK</title>
<link rel="stylesheet" type="text/css" href="./css/css.css">
</head>
<body>
<div class="exp-header">
  <a href="index.php">订单式接口</a>
  <a href="custompay.php">定制式接口</a>
  <a href="order.php" class="active">订单查询接口</a>
</div>
<?php if(isset($_POST["order_log"])): ?>
<div class="exp-container">
  <h2 class="exp-title">订单查询结果</h2>
  <div class="exp">
      <?php 

        echo "订单号:        ".$result->order_no."<br><br>";
        echo "订单支付状态:        ".$result->station."<br><br>";
        echo "订单支付金额:        ".$result->order_amount."元<br><br>";
        echo "下单时间:        ".$result->order_time."<br><br>";

      ?>
  </div>
</div> 
<?php else: ?>
<div class="exp-container">
  <h2 class="exp-title">订单查询</h2>
  <form action="order.php" method="post">
  <div class="exp">
    <input type="text" class="exp__input" name="order_sn" placeholder="订单号" required>
  </div>
  <div class="exp">
      <input type="hidden" name="order_log" value="1">
      <input type="submit" class="exp__input"  value="提交">
    </div>
  </form>
</div>
<?php endif; ?>
</body>
</html>