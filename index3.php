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
		<h1 class="demos-title"><img src="<?php echo $_SESSION["nowuserimg"]; ?>"></h1>
		<p class='demos-sub-title'>昵称:<?php echo $_SESSION["nowusername"]; ?></p>
	</header>
	<div class="weui_tab">
	  <div class="weui_navbar">
	    <a class="weui_navbar_item weui_bar_item_on" id="nav1">
	      我问
	    </a>
	    <a class="weui_navbar_item" id="nav2">
	      我答
	    </a>
	    <a class="weui_navbar_item" id="nav3">
	      我听
	    </a>
	  </div>
	  <div class="weui_tab_bd panel-body panel-body-1">
	      <div class="weui_media_box weui_media_small_appmsg weui_media_box-1" style="margin-top:5px">
		      <div class="weui_cells weui_cells_access">
			        <a class="weui_cell" href="javascript:;">
			          <div class="weui_cell_bd weui_cell_primary">
			            <p class="p1"><small style="color:gray" class="small1"></small></p>
			            <p class="p2" style="width:80%"></p>
			            <p class="p3"><small style="color:gray" class="small2"></small></p>
			          </div>
			          <div class="weui_cell_ft"><small class="flag"></small></div>
			        </a>
		      </div>
		 </div>
	   </div>
	   <div class="weui_tab_bd panel-body panel-body-2" style="margin-top:50px">
	      <div class="weui_media_box weui_media_small_appmsg weui_media_box-2" style="margin-top:5px">
		      <div class="weui_cells weui_cells_access">
			        <a class="weui_cell" href="javascript:;">
			          <div class="weui_cell_bd weui_cell_primary">
			            <p class="p1"><small style="color:gray" class="small1">我向谁提出：</small></p>
			            <p class="p2" style="width:80%">钢铁是怎么样炼成的？</p>
			            <p class="p3"><small style="color:gray" class="small2">2016-1-4 18:53:52</small></p>
			          </div>
			          <div class="weui_cell_ft"><small class="flag">未被回答</small></div>
			        </a>
		      </div>
		 </div>		 
	   </div>
	   <div class="weui_tab_bd panel-body panel-body-3" style="margin-top:50px">
	   
	      <div class="weui_media_box weui_media_small_appmsg weui_media_box-3" style="margin-top:5px">
		      <div class="weui_cells weui_cells_access">
			        <a class="weui_cell" href="javascript:;">
			          <div class="weui_cell_bd weui_cell_primary">
			            <p class="p1"><small style="color:gray" class="small1">我偷听：</small></p>
			            <p class="p2" style="width:80%">钢铁是怎么样炼成的？</p>
			            <p class="p3"><small style="color:gray" class="small2">2016-1-4 18:53:52</small></p>
			          </div>
			          <div class="weui_cell_ft"><small class="flag">被偷听</small></div>
			        </a>
		      </div>
		 </div>
	   </div>
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
			    <a href="index2.php" class="weui_tabbar_item ">
			        <p class="weui_tabbar_label " style="font-size:1em">答主</p>
			    </a>
			    <a href="javascript:;" class="weui_tabbar_item weui_bar_item_on">
			        <p class="weui_tabbar_label" style="font-size:1em">我的</p>
			    </a>
			</div>
		</div>
</div>
<script type="text/html" id="myask">
	
</script>
<script src="lib/jquery-2.1.4.js"></script>
<script src="lib/fastclick.js"></script>
<script src="js/jquery-weui.js"></script>
<script src="js/typed.min.js"></script>
<script type="text/javascript">
	$(function() {
    FastClick.attach(document.body);
    getallask();
    getallaskme();
    getlistenin();
    
    $(".panel-body").css("display","none");
    $(".panel-body-1").css("display","block");
    $(".weui_navbar_item").click(function(){
    		var self=$(this);
            $(".weui_navbar_item").removeClass("weui_bar_item_on");
            $(this).addClass("weui_bar_item_on");
            $(".panel-body").css("display","none");
            $(".panel-body-"+(self.index()+1)+"").css("display","block");
            switch(self.id)
           {
               case "nav1":
                   getallask();break;
               case "nav2":
                   getallaskme();break;
               case "nav3":
               		getlistenin();break;
           }
        });
  });
	function getallask(){
		
		$.get("asklist.php/?uid=<?php echo $_SESSION['nowuserid']?>",function(dat){
     		console.log(dat);
     		var data = JSON.parse(dat.split('<!--')[0]);
     		var str='';
     		if(data!=""){
     		for(var i=0;i<data.length;i++)
            {    $(".weui_media_box-1").eq(0).clone().appendTo(".panel-body-1");
               $(".weui_media_box-1").eq(i).find(".small1").html("我向"+data[i].nickname+"提出：").css({});
                $(".weui_media_box-1").eq(i).find(".p2").html(data[i].question);
                $(".weui_media_box-1").eq(i).find(".small2").html(data[i].asktime);
				if(parseInt(data[i].flag)==0)
                           str="未被回答";
                       else
                           str="已经回答";
              	$(".weui_media_box-1 .flag").eq(i).html(str);

            }
          $(".weui_media_box-1:last").remove();
			}else{
				$(".panel-body-1").html("<div style='margin-top:50px;text-align:center'>你有什么感兴趣的话题，<a href='index2.php'>赶紧去问吧</a></div>")
			}

     	});

	}
	function getallaskme(){
		$.get("askmelist.php/?uid=<?php echo $_SESSION['nowuserid']?>",function(dat){
     		console.log(dat);
     		var data = JSON.parse(dat.split('<!--')[0]);
     		var str='';
     		// alert(data[0].nickname);
     		if(data!=""){
     		for(var i=0;i<data.length;i++){
     			var url="answer.php?aid="+data[i].id
                            +"&nickname="+data[i].nickname+"&question="+data[i].question;
                $(".weui_media_box-2").eq(0).clone().appendTo(".panel-body-2");
                $(".weui_media_box-2").eq(i).find("a").attr("href",url);
               $(".weui_media_box-2").eq(i).find(".small1").html(data[i].nickname+"向我提出");
                $(".weui_media_box-2").eq(i).find(".p2").html(data[i].question);
                $(".weui_media_box-2").eq(i).find(".small2").html(data[i].asktime);
				if(parseInt(data[i].flag)==0)
                           str="未被回答";
                       else
                           str="已经回答";
              	$(".weui_media_box-2 .flag").eq(i).html(str);

            }
          		$(".weui_media_box-2:last").remove();
			}else{
				$(".panel-body-2").html("<div style='margin-top:50px;text-align:center'>还没有人向你提问</div>")
			}

     	});
	}
	function getlistenin(){
		$.get("listenlist.php?uid=<?php echo $_SESSION['nowuserid']?>",function(dat){
     		var data = JSON.parse(dat.split('<!--')[0]);
     		if(data!=""){
     			for(var i=0;i<data.length;i++)
            {    $(".weui_media_box-3").eq(0).clone().appendTo(".panel-body-3");
               $(".weui_media_box-3").eq(i).find(".small1").html("我偷听"+data[i].nickname+"的回答").css({});
                $(".weui_media_box-3").eq(i).find(".p2").html(data[i].question);
                $(".weui_media_box-3").eq(i).find(".small2").html(data[i].asktime);
              	$(".weui_media_box-3 .flag").eq(i).html(data[i].count+"人偷听");

            }
            $(".weui_media_box-3:last").remove();
     		}else{
     			$(".panel-body-3").html("<div style='margin-top:50px;text-align:center'>你还没有偷听，<a href='index.php'>赶紧去偷听吧</a></div>")
     		}
			})
	}
	
</script>
<script>
	
      
</script>

</body>
</html>