<?php
//通过code得到AccessToken
header("Content-type: text/html; charset=utf-8");
$url="https://api.weixin.qq.com/sns/oauth2/access_token?appid=wx19ad5c39489a99de&secret=436614189e0be8e4d7123b92a5efad49&code="
    .$_GET["code"]."&grant_type=authorization_code";
$result=httpGet($url);
// echo $result."<br>";
$restoken= json_decode($result);//把json字符串变成json对象
//echo $restoken->access_token."<br>";
//通过accestoken获取用户信息
$url2="https://api.weixin.qq.com/sns/userinfo?access_token=".$restoken->access_token
       ."&openid=".$restoken->openid."&lang=zh_CN";
$result2=httpGet($url2);
$userinfo=json_decode($result2);

$sql="insert into H5_user (type,openid,nickname,sex,province,city,country,headimgurl,privilege,unionid,mobile,college) values
 (0,'".$userinfo->openid."','".$userinfo->nickname."','".$userinfo->sex."','".$userinfo->province."','".$userinfo->city."','".$userinfo->country."','".$userinfo->headimgurl."','".$userinfo->privilege."','".$userinfo->unionid."','','')";
$dat=checkLogin($userinfo->openid,$sql);//检查用户登录
//var_dump($dat);
@session_start();
$_SESSION["nowuserid"]=$dat["id"];
$_SESSION["nowusername"]=$dat["nickname"];
$_SESSION["openid"]=$dat["openid"];
$_SESSION["nowuserimg"]=$dat["img"];
@header("location:index.php");

function httpGet($url) {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_TIMEOUT, 500);
    // 为保证第三方服务器与微信服务器之间数据传输的安全性，所有微信接口采用https方式调用，必须使用下面2行代码打开ssl安全校验。
    // 如果在部署过程中代码在此处验证失败，请到 http://curl.haxx.se/ca/cacert.pem 下载新的证书判别文件。
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, true);
    curl_setopt($curl, CURLOPT_URL, $url);

    $res = curl_exec($curl);
    curl_close($curl);

    return $res;
}
////检测用户登录 返回用户信息
function checkLogin($openid,$sql)
{   
  $db = mysql_connect(SAE_MYSQL_HOST_M.':'.SAE_MYSQL_PORT,SAE_MYSQL_USER,SAE_MYSQL_PASS);
    if ($db) {
        mysql_select_db(SAE_MYSQL_DB, $db);
        mysql_query("set names 'utf8'");
        echo "dbok";
    }
    $data=array();
    $res=mysql_query("select * from H5_user where openid='".$openid."'");
    if(mysql_num_rows($res)==0){//如果不存在就插入
          echo "<br>第一次登录,自动插入db<br>";
          $res1=mysql_query($sql);
          //插入成功后 查询出这个用户id
          if($res1)
          { $sql="select id,openid,nickname,headimgurl from H5_user where openid='".$openid."'";
            $resnow=mysql_query($sql);
            $row=mysql_fetch_array($resnow);
              $data["id"]=$row["id"];
              $data["openid"]=$row["openid"];
              $data["nickname"]=$row["nickname"];
              $data["img"]=$row["headimgurl"];
              return $data;
          }
    }else{
        //如果存在就获取
        $row=mysql_fetch_array($res);
        $data["id"]=$row["id"];
        $data["openid"]=$row["openid"];
        $data["nickname"]=$row["nickname"];
        $data["img"]=$row["headimgurl"];
        return $data;
    }

}

?>