<?php
 header("Content-Type: text/html; charset=UTF-8");
 error_reporting(E_ALL || ~E_NOTICE);
 ini_set('display_errors', '1');

  if(isset($_POST["order_create"]))
  {
  	  require_once "./lib/config.php";
      require_once "./lib/Log.class.php";
      require_once "./lib/Epay.class.php";  


      $EpayClient = new EpayClientAop($config);
      $LogClient  = new LogClientAop();

      /****改变请求网关****/
      $EpayClient->setWayUrl("https://www.payonline.xin/make.request");

      /****设置订单号****/
      $EpayClient->setOutTradeNo($_POST["order_no"]);

      /****设置支付商品名称****/
      $EpayClient->setSubject($_POST["subject"]);

      /****设置订单金额****/
      $EpayClient->setTradeAmount($_POST["order_amount"]);

      /****记录所有发出参数****/
      $data = $EpayClient->getAllparam();

      $LogClient->request_log($data);

      /****发送请求获取支付二维码或支付连接****/
      $result = $EpayClient->create($_POST["type"]);

      $result = json_decode($result); var_dump($result);

      /****处理生成二维码****/
      $result = $EpayClient->imgCode($result->pay_url);
      $img = "<img src=\"data:image/png;base64,".str_replace(PHP_EOL, '',$result)."\">";


?>
<script type="text/javascript" src="https://www.payonline.xin/static/js/jquery.min.js"></script>
<script type="text/javascript">

    /***轮询检查支付结果***/

    setInterval(function(){

      $.ajax({

        url : "./log/success.log",
        async : "true",
        dataType : 'json',
        type : "post",

        success:function(data) {

          if(data == <?php echo $_POST["order_no"]; ?>)
          {
            alert("支付成功!请自行完成剩余逻辑处理!");
          }
        },

        error:function(XMLHttpRequest, textStatus, errorThrown) {

            // 状态码
            console.log(XMLHttpRequest.status);
            // 状态
            console.log(XMLHttpRequest.readyState);
            // 错误信息   
            console.log(textStatus);
        }

      });

    },1000);

</script>
<?php
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
  <a href="custompay.php" class="active">定制式接口</a>
  <a href="order.php">订单查询接口</a>
</div>
<?php if(isset($_POST["order_create"])): ?>
<div class="exp-container">
  <h2 class="exp-title">订单支付</h2>
  <div class="exp">
      <?php echo $img;?>
  </div>
</div>
<?php else: ?>
<div class="exp-container">
  <h2 class="exp-title">创建订单</h2>
  <form action="custompay.php" method="post">
  <div class="exp">
    <input type="text" class="exp__input" name="order_no" readonly placeholder="订单号" required value="<?php echo Date('YmdHis').mt_rand(1000,9999);?>">
    <label class="exp__label" for="example">订单号</label>
  </div>
  <div class="exp">
    <select name="type" class="exp__input">
        <option value="alipay">支付宝</option>
        <option value="wechat">微信</option>
        <option value="qq">QQ</option>
    </select>
  </div>
  <div class="exp">
    <input type="text" class="exp__input"  name="subject" placeholder="商品名称" required>
  </div>
  <div class="exp">
    <input type="text" class="exp__input"  name="order_amount" placeholder="订单金额" required>
  </div>
  <div class="exp">
      <input type="hidden" name="order_create" value="1">
      <input type="submit" class="exp__input"  value="提交">
    </div>
  </form>
</div>
<?php endif; ?>
</body>
</html>