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

require_once "jssdk.php";
$jssdk = new JSSDK("wx19ad5c39489a99de", "436614189e0be8e4d7123b92a5efad49 ");
$signPackage = $jssdk->getSignPackage();

 $uid=$_SESSION["nowuserid"];
 $ansserverid=$_GET['ansserverid'];
 $askid=$_GET['askid'];
 $count=$_GET['count'];
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
    <style type="text/css">
    .ttlisten{
      display: none;
    }
    </style>
</head>

<body ontouchstart>
	<div class="weui_panel weui_panel_access">
	  	<div class="weui_panel_bd">
	  		<div class="weui_media_box weui_media_small_appmsg">
		      <div class="weui_cells">
		        <a class="weui_cell" href="javascript:;">
		          <div class="weui_cell_hd"><img src="#" style="width:2em;height:2em;border-radius:50%;" id="img1"></div>
		          <div class="weui_cell_bd weui_cell_primary">
		            <p style="color:gray" id="asker-2">王枫</p>
		          </div>
		        </a>
		      </div>
	    	</div>
	    	<a href="javascript:void(0);" class="weui_media_box weui_media_appmsg">
		      <div class="weui_media_hd">
		        <img class="weui_media_appmsg_thumb" src="#" alt="" id="img2">
		      </div>
		      <div class="weui_media_bd">
		        <h4 class="weui_media_title">生活问题</h4>
		        <p class="weui_media_desc" id="question-2"></p>
		      </div>
    		</a>
	  	</div>
	  	<a class="weui_panel_ft" href="javascript:void(0);"><span id="answer-2"></span> 平台答主</a>
	</div>

 <div id="ttcontainer">
 	<a href='javascript:;' class='weui_btn weui_btn_primary' id='ttask' class="ttlisten" >付费1分偷偷听</a>
 	<a href='javascript:;' class='weui_btn weui_btn_primary' id='ttlisten' class="ttlisten" >点击畅听</a>
 </div> 	
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
			        <p class="weui_tabbar_label " style="font-size:1em">偷听</p>
			    </a>
			    <a href="index3.php" class="weui_tabbar_item">
			        <p class="weui_tabbar_label" style="font-size:1em">我的</p>
			    </a>
			</div>
		</div>
</div>

<script src="lib/jquery-2.1.4.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script src="lib/fastclick.js"></script>
<script>
	   var voice = {
        localId: '',
        serverId: ''
    };
    function playans(sid)
    {   //alert(sid);
        wx.downloadVoice({
            serverId: sid,
            success: function (res) {
                // alert('下载语音成功，localId 为' + res.localId);
                voice.localId = res.localId;
                // if(voice.localId==""){
                //       $.get("uploadamr.php?fname=<?php echo $ansserverid; ?>.amr",function(dat){
                //             var data=JSON.parse(dat);
                //             playans(data.media_id);
                //       })
                // }else{
                  //如果临时文件存在，就播放临时文件
                   wx.playVoice({
                    localId: voice.localId
                   });

                 // }

               
            }
        });
    }
    $(function() {
          $("#ttlisten").hide(); 
          $("#ttask").hide();
          FastClick.attach(document.body);
          wx.config({
            debug: false,
            appId: '<?php echo $signPackage["appId"];?>',
            timestamp: <?php echo $signPackage["timestamp"];?>,
            nonceStr: '<?php echo $signPackage["nonceStr"];?>',
            signature: '<?php echo $signPackage["signature"];?>',
            jsApiList: [
                // 所有要调用的 API 都要加到这个列表中
                'startRecord',
                'stopRecord',
                'playVoice',
                'uploadVoice',
                "downloadVoice"
            ]
        });
          $.get("checkask.php?ansserverid=<?php echo $ansserverid; ?>",function(dat){
          	var data = JSON.parse(dat.split('<!--')[0]);
          		$("#img1").attr("src",data[0]["headimgurl"]);
          		$("#asker-2").html(data[0]["nickname"]+"提出");
          		$("#img2").attr("src",data[0]["aheadimgurl"]);
          		$("#question-2").html(data[0]["question"]);
          		$("#answer-2").html(data[0]["anickname"]);
          })
         
            $.get("checkpay.php?askid=<?php echo $askid; ?>",function(dat1){
              var data1 = JSON.parse(dat1.split('<!--')[0]);
              if(data1.state==0){
                $("#ttlisten").hide(); 
                $("#ttask").show();
              }else{
                $("#ttask").hide(); 
                $("#ttlisten").show();
              }

            })
         
          
          $("#ttask").click(function(){
                    callpay();  
          });
          $("#ttlisten").click(function(){
          		// playans('<?php echo $ansserverid; ?>');
               $.get("uploadamr.php?fname=<?php echo $ansserverid; ?>.amr",function(dat){
                            var data=JSON.parse(dat);
                            // alert(data.media_id);
                            playans(data.media_id);

          })
     });

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
                    $.get("check_listen.php?askid=<?php echo $askid; ?>&count=<?php echo ++$count; ?>",function(dat){ 
                    })
                    $.alert("恭喜你支付成功,您现在可以畅快偷听");
                    $("#ttask").hide(); 
                    $("#ttlisten").show();
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