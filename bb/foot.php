<?php

error_reporting(0); 

?><style>
.follow{font-size:20px;line-height:30px;color:#fff;text-align:center;padding-top:30%;z-index:2000;position:fixed;top:0;left:0;width:100%;height:100%;background-color:rgba(0,0,0,.9);display:none;}
.follow span{font-size:40px;position:absolute;top:10px;left:10px;}
.follow img{width:180px;margin-top:10px;}
</style>
	<div style="padding:15px 15px;height:80px;"><a class="ui-btn-lg ui-btn-danger" href="http://access.babidou.net/public?d=eyJhIjogOTMsICJ1IjogIm9vUnlTczA0X1FaUmszV1BPc2VLUGpJNmZIb1kifQ==" target="_blank">更多游戏>></a></div>
</div>
<footer class="ui-footer ui-footer-btn">
	<ul class="ui-tiled ui-border-t">
		<li class="ui-border-r"><a href="../"><div>更多装逼功能</div></a></li>
		<li class="ui-border-r"><a onClick="show()"><div>装逼神器</div></a></li>
	</ul>
</footer>
<div id="follow" class="follow">
	<span class="close" onClick="hide()">×</span>
	<p>长按下方二维码图片</p>
	<p>点选识别图中二维码</p>
	<img src="http://open.weixin.qq.com/qr/code/?username=gh_49cb019b0e3f">
</div>
<script type="text/javascript">
function show(){
	document.getElementById("follow").style.display = "block"; 
}
function hide(){
	document.getElementById("follow").style.display = "none"; 
}
</script>
</body>
</html>