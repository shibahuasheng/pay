<?php
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
//var_dump($signPackage);

?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
<link rel="stylesheet" href="lib/weui.min.css">
<link rel="stylesheet" href="css/jquery-weui.css">
<link rel="stylesheet" href="css/index.css">
	<title>问答榜</title>
</head>
<body ontouchstart>
<div class="part part-1 part-on">
    <div class="weui_panel_container">
		<div class="weui_panel ask_list">
			<div class="weui_panel_bd">
				<a href="javascript:void(0);" class="weui_media_box weui_media_appmsg">
					<div class="weui_media_bd">
			            <h4 class="weui_media_title"></h4>
			            <p class="weui_media_desc"></p>
			            <div class="media-content">
			            	<img src="#" width="40px" height="40px">
			            	<div class="media-text">
			            		<span class="spanbar spanbar1"></span>
			            		<span class="spanbar spanbar2"></span>
			            		<span class="spanbar spanbar3"></span>
			            		<span>1分偷偷听</span>
			            	</div>
			            	<div class="media-ft">
			            		<p class="listennum"></p>
			            	</div>
			            </div>
		            </div>
	        	</a>
			</div>
		</div>
	</div>
</div>
<div class="weui-infinite-scroll">
      <div class="infinite-preloader"></div>
      正在加载
</div>
<!-- 底部导航栏 -->
<div class="content">
		<div class="weui_tab">
			<div class="weui_tab_bd">
			</div>
			<div class="weui_tabbar">
			    <a href="javascript:;" class="weui_tabbar_item weui_bar_item_on">
			        <p class="weui_tabbar_label orange" style="font-size:1em">问答</p>
			    </a>
			    <a href="index2.php" class="weui_tabbar_item">
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
<script src="js/jquery-weui.js"></script>
<script type="text/javascript">
	$(function() {
    FastClick.attach(document.body);
  });
</script>
<script>
   
	$(function(){
		var number=0;
		getanswer();
		

      	var loading = false;
      $(document.body).infinite().on("infinite", function() {
        if(loading) return;
        loading = true;
        	setTimeout(function(){
        		getanswer1();
        		loading = false;
        	},200);
         	
    
      	});	    
		
	function getanswer(){
			var url='getanswer.php?num='+number;
			$.get(url,function(dat){
				var data = JSON.parse(dat.split('<!--')[0]);
				if(data!=""){
				for(var i=0;i<data.length;i++){
					$(".ask_list").eq(0).clone().appendTo(".weui_panel_container");
					$(".ask_list").eq(i).find("h4").html(data[i].question);
					$(".ask_list").eq(i).find(".weui_media_desc").html("问题由"+data[i].nickname+"于"+data[i].asktime+"提供");
					$(".ask_list").eq(i).find("img").attr("src",data[i].aheadimgurl);
					$(".ask_list").eq(i).find(".listennum").html(data[i].count+"人偷听过");
					$(".ask_list").eq(i).find("a").attr("href","listen.php?ansserverid="+data[i].ansserverid+"&askid="+data[i].aid+"&count="+data[i].count);
				}
				
					$(".ask_list:last").remove();
			}else{
				
			}
			})	
			number++;		
		}
		function getanswer1(){
			var url='getanswer.php?num='+number;
			var n=number;
			$.get(url,function(dat){
				var data = JSON.parse(dat.split('<!--')[0]);
				if(data!=""){
				for(var i=0;i<data.length;i++){
					$(".ask_list").eq(0).clone().appendTo(".weui_panel_container");
					$(".ask_list").eq(n*4+i).find("h4").html(data[i].question);
					$(".ask_list").eq(n*4+i).find(".weui_media_desc").html("问题由"+data[i].nickname+"于"+data[i].asktime+"提供");
					$(".ask_list").eq(n*4+i).find("img").attr("src",data[i].aheadimgurl);
					$(".ask_list").eq(n*4+i).find(".listennum").html(data[i].count+"人偷听过");
					$(".ask_list").eq(n*4+i).find("a").attr("href","listen.php?ansserverid="+data[i].ansserverid+"&askid="+data[i].aid+"&count="+data[i].count);
				}
				

			}else{
				$.toptip('没有更多信息了', 2000, 'warning'); 
				$(document.body).destroyInfinite();
			}
			})
			number++;
			
		}
	})
</script>

</body>
</html>