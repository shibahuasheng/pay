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
$input->SetGoods_tag("test");
$input->SetNotify_url("http://h5edu.applinzi.com/wxpay/example/notify.php");
$input->SetTrade_type("JSAPI");
$input->SetOpenid($openId);
$order = WxPayApi::unifiedOrder($input);
echo '<font color="#f00"><b>统一下单支付单信息</b></font><br/>';
//printf_info($order);
$jsApiParameters = $tools->GetJsApiParameters($order);

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
    <style type="text/css">
        .demos-title {
            text-align: center;
            font-size: 34px;
            color: #3cc51f;
            font-weight: 400;
            margin: 0 15%;
        }

        .demos-sub-title {
            text-align: center;
            color: #888;
            font-size: 14px;
        }

        .demos-header {
            padding: 35px 0;
        }
        .demos-title img{
            border-radius: 50%;
            width: 80px;
        }

        #index_tab{
            position: fixed;
            left: 0;
            bottom: 0;

        }
    </style>
</head>

<body ontouchstart>

<input type="hidden" id="touid" value="<?php echo $_GET["qid"]; ?>">
<input type="hidden" id="uid" value="<?php echo $_SESSION["nowuserid"]; ?>">
<div class="weui_cells weui_cells_form">
    <div class="weui_cells_title">请输入您关注的问题：</div>
    <div class="weui_cells weui_cells_form">
        <div class="weui_cell" style="background-color: #528CE0;color: white">
            <div class="weui_cell_bd weui_cell_primary" style="background-color: #528CE0;color: white">
                <textarea onfocus="$('#index_tab').hide();" onblur="$('#index_tab').show();" onchange="javascript:fun333();" id="question" class="weui_textarea" style="background-color: #528CE0;color: white"  placeholder="请输入关注的问题，H5EDU讲师会在24小时回答您的问题如果没回答会退还费用" rows="3"></textarea>
                <div class="weui_textarea_counter"><span id="nowl">0</span>/200</div>
            </div>
        </div>
    </div>
    <div class="weui_cells_title"><smal>答案被瞄一眼会得到0.5元</smal></div>
</div>
<header class='demos-header'>
    <h1 class="demos-title"><img src="<?php echo $_GET["qimg"];?>"></h1>
    <p class='demos-sub-title'>提问对象:<?php echo $_GET["nickname"];?></p>
</header>
<a href="javascript:;" class="weui_btn weui_btn_primary" id="btask">付费1元提问</a>
<div style="height: 50px"></div>
<div class="weui_tabbar" id="index_tab">
    <a href="javascript:;" class="weui_tabbar_item ">
        <div class="weui_tabbar_icon">
            <img src="./images/icon_nav_button.png" alt="">
        </div>
        <p class="weui_tabbar_label">有料</p>
    </a>
    <a href="javascript:;" class="weui_tabbar_item ">
        <div class="weui_tabbar_icon">
            <img src="./images/icon_nav_article.png" alt="">
        </div>
        <p class="weui_tabbar_label">发现</p>
    </a>
    <a href="javascript:;" class="weui_tabbar_item weui_bar_item_on">
        <div class="weui_tabbar_icon">
            <img src="./images/icon_nav_cell.png" alt="">
        </div>
        <p class="weui_tabbar_label">我</p>
    </a>
</div>

<script src="lib/jquery-2.1.4.js"></script>
<script src="lib/fastclick.js"></script>
<script>
    $(function() {

          FastClick.attach(document.body);

          $("#btask").click(function(){
             //表单验证
              if( $("#question").val().length>0)
              {   alert($("#touid").val()+","+$("#uid").val()+","+$("#question").val());
                //插入到数据库
                  $.post("http://h5edu.applinzi.com/askquestion.php",
                      {"touid":$("#touid").val(),
                          "uid":$("#uid").val(),
                        "question":$("#question").val()},function(data,state){
                          alert(state);
                        });
              }
          });
     });
    function fun333(){
        var nowl= $("#question").val().length;
        if(nowl<200)
        { $("#nowl").html(nowl);
        }else{
            $.alert("对不起，不能超过200字");
            $("#question").blur();
        }
    }
</script>
<script src="js/jquery-weui.js"></script>

</body>

</html>
