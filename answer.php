<?php
require_once "jssdk.php";
$jssdk = new JSSDK("wx19ad5c39489a99de", "436614189e0be8e4d7123b92a5efad49 ");
$signPackage = $jssdk->getSignPackage();
//var_dump($signPackage);



?>

<!DOCTYPE html>
<html>
<head>
    <title>你来问，我来答</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <link rel="stylesheet" href="lib/weui.min.css">
    <link rel="stylesheet" href="css/jquery-weui.css">
    <link rel="stylesheet" href="css/index.css">
</head>
<body ontouchstart>
<div class="weui_msg">
    <div class="weui_text_area">
        <h2 class="weui_msg_title">提问者:<?php echo $_GET["nickname"]; ?></h2>
        <p class="weui_msg_desc">问题内容:<?php echo $_GET["question"]; ?></p>
    </div>
    <div class="weui_opr_area">
        <p class="weui_btn_area">
            <a href="javascript:;" id="bt02" class="weui_btn weui_btn_primary">开始录音</a>
            <a href="javascript:;" id="bt03" class="weui_btn weui_btn_default">停止录音</a>
            <a href="javascript:;" id="bt04" class="weui_btn weui_btn_default">播放录音</a>
        </p>
    </div>

</div>
<script src="lib/jquery-2.1.4.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script src="lib/fastclick.js"></script>
<script src="js/jquery-weui.js"></script>
<script>
    $(function() {
        FastClick.attach(document.body);
        //alert(1);
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
                'uploadVoice'
            ]
        });
        var voice = {
            localId: '',
            serverId: ''
        };
        wx.ready(function () {
        //alert(2);
        document.getElementById("bt02").onclick=function(){
            wx.startRecord({
                cancel: function () {
                    alert('用户拒绝授权录音');
                }
            });
        };
        document.getElementById("bt03").onclick=function(){
            wx.stopRecord({
                success: function (res) {
                    voice.localId = res.localId;
                    wx.uploadVoice({
                        localId: voice.localId,
                        success: function (res) {
                            //alert('上传语音成功，serverId 为' + res.serverId);
                            voice.serverId = res.serverId;

                            //插入到数据库中
                            var url="update_ask.php?aid=<?php echo $_GET['aid']; ?>&serverid="+res.serverId;
                           // alert(url);
                            $.get(url,null,
                               function(dat){
                                  alert("问题回答完毕，2秒钟自动返回 ");
                                   setTimeout(function(){
                                       window.location.href="index3.php";
                                   },2000);
                               });
                            //保存在本地文件中
                          $.get("getMedia.php?mid="+res.serverId+"&ext=amr",function(dat){
                            // alert(dat);
                           })
                        }
                    });
                },
                fail: function (res) {
                    alert(JSON.stringify(res));
                }
            });
        };
        document.getElementById("bt04").onclick=function(){
            if (voice.localId == '') {
                alert('请先使用 startRecord 接口录制一段声音');
                return;
            }
            wx.playVoice({
                localId: voice.localId
            });
        };
       });
    });

</script>


</body>

</html>