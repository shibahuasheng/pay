<?php
require_once "jssdk.php";
$jssdk = new JSSDK("wx19ad5c39489a99de", "436614189e0be8e4d7123b92a5efad49 ");
$signPackage = $jssdk->getSignPackage();
//var_dump($signPackage);

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title></title>
  <style type="text/css">
    li{
      background-color: aliceblue;
      font-size: 22px;
      font-family: '黑体';
      color: black;
      height:120px;
      list-style: none;
    }
  </style>
</head>
<body>
<ul>
  <li id="bt01">检测当前是否支持微信 JS SDK</li>
  <li id="bt02">录音</li>
  <li id="bt03">停止录音</li>
  <li id="bt04">播放</li>
    <li id="bt05">上传</li>
    <li id="bt06">下载</li>
  <li id="imageSelect">选取图片</li>
  <li id="previewImage">预览图片</li>
  <li id="uploadImage">上传图片</li>
  <li id="downloadImage">下载图片</li>
  <li id="tv">语音识别</li>
  <li id="getnetState">获取网络状态</li>
  <li id="getlocation">获取坐标</li>
  <li id="openlocation">显示一个坐标</li>
</ul>
    <div id="log"></div>
</body>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
    <script src="jquery-2.1.4.js"></script>
<script>
  wx.config({
    debug: false,
    appId: '<?php echo $signPackage["appId"];?>',
    timestamp: <?php echo $signPackage["timestamp"];?>,
    nonceStr: '<?php echo $signPackage["nonceStr"];?>',
    signature: '<?php echo $signPackage["signature"];?>',
    jsApiList: [
      // 所有要调用的 API 都要加到这个列表中
      'onMenuShareTimeline',
      'onMenuShareAppMessage',
      'checkJsApi',
      'startRecord',
      'stopRecord',
      'playVoice',
      'onMenuShareTimeline',
       'onMenuShareAppMessage',
        'chooseImage',
        'previewImage',
        'uploadImage',
        'downloadImage',
        'translateVoice',
        'getNetworkType',
        'getLocation',
        'openLocation',
      'hideOptionMenu',
      "uploadVoice",
      "downloadVoice"
    ]
  });
  var voice = {
    localId: '',
    serverId: ''
  };
  var location={
     lat:0,
     long:0
  };
  wx.ready(function () {
      wx.hideOptionMenu(); //隐藏右上角的菜单

    //获取经纬度坐标
    document.getElementById("getlocation").onclick=function() {
      wx.getLocation({
        type: 'wgs84', // 默认为wgs84的gps坐标，如果要返回直接给openLocation用的火星坐标，可传入'gcj02'
        success: function (res) {
          location.lat = res.latitude; // 纬度，浮点数，范围为90 ~ -90
          location.long = res.longitude; // 经度，浮点数，范围为180 ~ -180。
          var speed = res.speed; // 速度，以米/每秒计
          var accuracy = res.accuracy; // 位置精度
        }
      });
    };
    //显示一个坐标
    document.getElementById("openlocation").onclick=function(){
      wx.openLocation({
        latitude: location.lat, // 纬度，浮点数，范围为90 ~ -90
        longitude: location.long, // 经度，浮点数，范围为180 ~ -180。
        name: 'H5edu实训基地', // 位置名
        address: '北京H5EDU实训基地', // 地址详情说明
        scale: 12, // 地图缩放级别,整形值,范围从1~28。默认为最大
        infoUrl: '' // 在查看位置界面底部显示的超链接,可点击跳转
      });
    };
    //获取网络状态
    document.getElementById("getnetState").onclick=function(){
      wx.getNetworkType({
        success: function (res) {
          var networkType = res.networkType; // 返回网络类型2g，3g，4g，wifi
          alert("当前您手机的网络状态"+networkType);
        }
      });
    };

    //语音识别
    document.getElementById("tv").onclick=function(){
      if(voice.localId=="")
      {
        alert("请先录制一段语音");
        return;
      }
    wx.translateVoice({
      localId:voice.localId, // 需要识别的音频的本地Id，由录音相关接口获得
      isShowProgressTips: 1, // 默认为1，显示进度提示
      success: function (res) {
        alert(res.translateResult); // 语音识别的结果
      }
    });
    };
    var images = {
      localId: [],
      serverId: []
    };
    document.querySelector('#imageSelect').onclick = function () {
      wx.chooseImage({
        success: function (res) {
          images.localId = res.localIds;
          alert('已选择 ' + res.localIds.length + ' 张图片');
        }
      });
    };

    // 5.2 图片预览
    document.querySelector('#previewImage').onclick = function () {
      wx.previewImage({
        current: 'http://img5.douban.com/view/photo/photo/public/p1353993776.jpg',
        urls: [
          'http://img3.douban.com/view/photo/photo/public/p2152117150.jpg',
          'http://img5.douban.com/view/photo/photo/public/p1353993776.jpg',
          'http://img3.douban.com/view/photo/photo/public/p2152134700.jpg'
        ]
      });
    };

    // 5.3 上传图片
    document.querySelector('#uploadImage').onclick = function () {
      if (images.localId.length == 0) {
        alert('请先使用 chooseImage 接口选择图片');
        return;
      }
      var i = 0, length = images.localId.length;
      images.serverId = [];
      function upload() {
        wx.uploadImage({
          localId: images.localId[i],
          success: function (res) {
            i++;
              alert('已上传：' + i + '/' + length+",sid:"+res.serverId);
              $("#log").html(res.serverId);
            images.serverId.push(res.serverId);
              //调用
              
              $.get("getMedia.php","ext=jpg&mid="+res.serverId,function(data){
                  alert("下载:"+data)
              });
              
            if (i < length) {
              upload();
            }
          },
          fail: function (res) {
            alert(JSON.stringify(res));
          }
        });
      }
      upload();
    };

    // 5.4 下载图片
    document.querySelector('#downloadImage').onclick = function () {
      if (images.serverId.length === 0) {
        alert('请先使用 uploadImage 上传图片');
        return;
      }
      var i = 0, length = images.serverId.length;
      images.localId = [];
      function download() {
        wx.downloadImage({
          serverId: images.serverId[i],
          success: function (res) {
            i++;
            alert('已下载：' + i + '/' + length);
            images.localId.push(res.localId);
            if (i < length) {
              download();
            }
          }
        });
      }
      download();
    };
    //分享给好友
    wx.onMenuShareAppMessage({
      title: '程龙在直播，快来看', // 分享标题
      desc: '大牛直播微信开发', // 分享描述
      link: 'http://www.douyu.com/room/share/4809', // 分享链接
      imgUrl: 'http://img5.imgtn.bdimg.com/it/u=1049485192,568388515&fm=21&gp=0.jpg', // 分享图标
      type: 'link', // 分享类型,music、video或link，不填默认为link
      dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
      success: function () {
        // 用户确认分享后执行的回调函数
        alert("谢谢");
      },
      cancel: function () {
        // 用户取消分享后执行的回调函数
      }
    });
    //分享到朋友圈是否成功
    wx.onMenuShareTimeline({
      title: '我在h5edu学习微信开发', // 分享标题
      link: 'http://h5edu.applinzi.com/sample.php', // 分享链接
      imgUrl: 'http://www.h5edu.cn/Public/assets/img/logo_blue.png', // 分享图标
      success: function () {
        // 用户确认分享后执行的回调函数
        alert("谢谢你，你今天会有好运");
      },
      cancel: function () {
        // 用户取消分享后执行的回调函数
      }
    });
    // 在这里调用 API
    document.getElementById("bt01").onclick=function(){
      wx.checkJsApi(
          {jsApiList:[
            'onMenuShareTimeline',
            'playVoice'
          ],
            success:function(res){
              alert(JSON.stringify(res));
            }
          }
      );
    };

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
      document.querySelector('#bt05').onclick = function () {
    if (voice.localId == '') {
      alert('请先使用 startRecord 接口录制一段声音');
      return;
    }
    wx.uploadVoice({
      localId: voice.localId,
      success: function (res) {
        alert('上传语音成功，serverId 为' + res.serverId);
        voice.serverId = res.serverId;
            
              $.get("getMedia.php","ext=mp3&mid="+res.serverId,function(data){
                  alert("下载:"+data)
              });
      }
    });
         
    

  };
       document.querySelector('#bt06').onclick = function () {
  
    wx.downloadVoice({
      serverId: "ty5wY92G5AtG_QskB5xevdZHvqp9VPdtqacngavU4vnhL4N09_sqekPjLzUGtRqo",
      success: function (res) {
        alert('下载语音成功，localId 为' + res.localId);
        voice.localId = res.localId;
      }
    });
  };
  });
</script>
</html>
