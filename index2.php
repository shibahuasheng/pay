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
	<header class='demos-header'>
	    <h1 class="demos-title">AS问答平台</h1>
	    <p class='demos-sub-title'>学知识、聊八卦</p>
	</header>
	<div class="weui_grids" id="allteacher">
	    <a href="#" class="weui_grid js_grid">
	        <div class="weui_grid_icon">
	            <img src="" alt="" class="userimg">
	        </div>
	        <p class="weui_grid_label" class="username">

	        </p>
	    </a>
	</div>

<div class="demos-header" id="usersubmit">
    <h2 class='demos-second-title'>你想成为答主吗？</h2>
    <p class='demos-sub-title' style="text-decoration: underline">申请成为答主</p>
</div>
<div style="height: 50px"></div>
<!-- 底部导航栏 -->
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
<script src="js/jquery-weui.js"></script>
<script type="text/javascript">
	$(function() {
    FastClick.attach(document.body);
     	$.get("gettecherlist.php",function(dat){
     		console.log(dat);
     		var data = JSON.parse(dat.split('<!--')[0])
     		for(var i=0;i<data.length;i++)
            {
                $(".js_grid").eq(0).clone().appendTo("#allteacher");
                $(".js_grid").eq(i).find('img').attr('src',data[i]['headimgurl']);
                if(data[i]['nickname'].length>5)
                {
                    data[i]['nickname']=data[i]['nickname'].substr(0,5)+"...";
                }
                $(".js_grid").eq(i).find('p').html(data[i]['nickname']);
                $(".js_grid").eq(i).attr("href","ask.php?qid="+data[i]['id']+"&nickname="
                            + data[i]['nickname']+"&qimg="+data[i]['headimgurl']);

            }
            $(".js_grid:last").remove();


     	});
     	$("#usersubmit").click(function(){
            $(".content").hide();
            $.prompt({
                text: "请输入您的基本介绍",
                title: "申请理由",
                onOK: function(text) {
                    $("#index_tab").show();
                    $.alert("谢谢 您的申请已经收到");
                },
                onCancel: function() {
                    $(".content").show();
                    console.log("取消了");
                },
                input: ''
            });
        });	


        // $.getJSON("http://1.tengxunkeng.applinzi.com/youliao/gettecherlist.php","",function(dat){
        // 	console.log(dat);
        // 	alert(111);
        //     for(var i=0;i<dat.length;i++)
        //     {
        //         $(".js_grid").eq(0).clone().appendTo("#allteacher");
        //         $(".js_grid").eq(i).find('img').attr('src',dat[i]['headimgurl']);
        //         if(dat[i]['nickname'].length>5)
        //         {
        //             dat[i]['nickname']=dat[i]['nickname'].substr(0,5)+"...";
        //         }
        //         $(".js_grid").eq(i).find('p').html(dat[i]['nickname']);
        //         $(".js_grid").eq(i).attr("href","ask.php?qid="+dat[i]["id"]+"&nickname="
        //                     + dat[i]['nickname']+"&qimg="+dat[i]['headimgurl']);

        //     }
        //     $(".js_grid:last").remove();
        // });
  });
</script>
</body>
</html>