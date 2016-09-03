<?php
ini_set('date.timezone','Asia/Shanghai');
//error_reporting(E_ERROR);
require_once "wxpay/lib/WxPay.Api.php";
require_once "wxpay/example/WxPay.JsApiPay.php";

session_start();
if(!isset($_SESSION["nowuserid"]))//说明用户没有登录
{
    $callback=urlencode("http://h5edu.applinzi.com/login.php");
    $url="https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx19ad5c39489a99de&redirect_uri="
        .$callback."&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";

    header("location:".$url);//跳转到微信授权
    exit();
}
//①、获取用户openid
$tools = new JsApiPay();
$openId = $tools->GetOpenid();

//②、统一下单
$input = new WxPayUnifiedOrder();
$input->SetBody("付费问答支付费用");
$input->SetAttach("uid3");
$input->SetOut_trade_no(WxPayConfig::MCHID.date("YmdHis"));
$input->SetTotal_fee("1");
$input->SetTime_start(date("YmdHis"));
$input->SetTime_expire(date("YmdHis", time() + 600));
$input->SetGoods_tag("H5EDU付费问答支");
$input->SetNotify_url("http://h5edu.applinzi.com/wxpay/example/notify.php");
$input->SetTrade_type("JSAPI");
$input->SetOpenid($openId);
$order = WxPayApi::unifiedOrder($input);
//echo '<font color="#f00"><b>统一下单支付单信息</b></font><br/>';
//printf_info($order);
 $jsApiParameters = $tools->GetJsApiParameters($order);
 $touid=$_GET["qid"];
 $uid=$_SESSION["nowuserid"];
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>
    <title>提问</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <link rel="stylesheet" href="lib/weui.min.css">
    <link rel="stylesheet" href="css/jquery-weui.css">
    <link rel="stylesheet" href="css/index.css">
</head>

<body ontouchstart>
<div class="weui_cells weui_cells_form" style="margin-top:0px">
    <div class="weui_cells_title">请输入您关注的问题：</div>
    <div class="weui_cells weui_cells_form">
        <div class="weui_cell" style="background-color: #528CE0;color: white">
            <div class="weui_cell_bd weui_cell_primary" style="background-color: #528CE0;color: white">
                <textarea  onfocus="$('.content').hide();" onblur="$('.content').show();" onchange="$('#nowl').html($('#question').val().length);$('#btask').removeClass('weui_btn_disabled')" id="question" class="weui_textarea" style="background-color: #528CE0;color: white"  placeholder="请输入关注的问题，问题需付费1分钱,答主会在24小时回答您的问题如果没回答会退还费用" rows="3"></textarea>
                <div class="weui_textarea_counter"><span id="nowl">0</span>/200</div>
            </div>
        </div>
    </div>
    <div class="weui_cells_title"><smal>答案被瞄一眼会得到0.01元</smal></div>
</div>
<header class='demos-header'>
    <h1 class="demos-title"><img src="<?php echo $_GET["qimg"];?>"></h1>
    <p class='demos-sub-title'>提问对象:<?php echo $_GET["nickname"];?></p>
</header>
<a href="javascript:;" class="weui_btn weui_btn_primary" id="btask">付费1分提问</a>
<div style="height: 50px"></div>
<div class="content">
		<div class="weui_tab">
			<div class="weui_tab_bd">
			</div>
			<div class="weui_tabbar">
			    <a href="index.php" class="weui_tabbar_item ">
			        <p class="weui_tabbar_label orange" style="font-size:1em">问答</p>
			    </a>
			    <a href="javascript:;" class="weui_tabbar_item weui_bar_item_on">
			        <p class="weui_tabbar_label " style="font-size:1em">答主</p>
			    </a>
			    <a href="index3.php" class="weui_tabbar_item">
			        <p class="weui_tabbar_label" style="font-size:1em">我的</p>
			    </a>
			</div>
		</div>
</div>

<script src="lib/jquery-2.1.4.js"></script>
<script src="lib/fastclick.js"></script>
<script>
    $(function() {
          FastClick.attach(document.body);
          $("#btask").click(function(){
             //表单验证
              if( $("#question").val().length>0)
              { 
                 callpay();
                 }else{
                      $("#btask").addClass("weui_btn_disabled");           
                 }
              })
          });
   
 //调用微信JS api 支付
    function jsApiCall()
    {
        WeixinJSBridge.invoke(
            'getBrandWCPayRequest',
            <?php echo $jsApiParameters; ?>,
            function(res){
//                WeixinJSBridge.log(res.err_msg);
                 //alert(res.err_msg);
                 if(res.err_msg.indexOf("ok")>0){
                     //插入到数据库
                    $.post("askquestion.php",
                         {"touid":"<?php echo $touid; ?>",
                             "uid":"<?php echo $uid; ?>",
                             "question":$("#question").val()},function(data){
                               // alert("插入数据库成功");     
                         });
                     $.alert("恭喜你支付成功,您的提问已经受理");
                     $("#question").val('');
                 }
            }
        );
    }

    function callpay()
    {
        if (typeof WeixinJSBridge == "undefined"){
            if( document.addEventListener ){
                document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
            }else if (document.attachEvent){
                document.attachEvent('WeixinJSBridgeReady', jsApiCall);
                document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
            }
        }else{
            jsApiCall();
        }
    }
</script>
<script src="js/jquery-weui.js"></script>

</body>

</html>