<!DOCTYPE html>
<html>
<head>
    <title>H5EDU 问答</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<?php
//require_once "conn.php";
//2得到Code
//echo $_GET["code"]."<br>";
//3.通过code得到AccessToken
$url="https://api.weixin.qq.com/sns/oauth2/access_token?appid=wx19ad5c39489a99de&secret=436614189e0be8e4d7123b92a5efad49&code="
    .$_GET["code"]."&grant_type=authorization_code";
$result=httpGet($url);
//echo $result."<br>";
$restoken= json_decode($result);//把json字符串变成json对象
echo $restoken->access_token."<br>";
////4通过accestoken获取用户信息
$url2="https://api.weixin.qq.com/sns/userinfo?access_token=".$restoken->access_token
       ."&openid=".$restoken->openid."&lang=zh_CN";
$result2=httpGet($url2);
$userinfo=json_decode($result2);
echo "<img src=".$userinfo->headimgurl."><br>";
echo "<h2>欢迎".$userinfo->nickname."登录H5edu问答</h2>";
echo "</body>";
////通过函数来完成用户登录验证
//
////插入到数据库
$sql="insert into h5_user (type,openid,nickname,sex,province,city,country,headimgurl,privilege,unionid,mobile,college) values
(0,'".$userinfo->openid."','".$userinfo->nickname."','".$userinfo->sex."','".$userinfo->province."','".$userinfo->city."','".$userinfo->country."','".$userinfo->headimgurl."','".$userinfo->privilege."','".$userinfo->unionid."','','')";
//echo $sql;
checkLogin($userinfo->openid,$sql);//检查用户登录
//
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
    //检查数据库是否存在openid
    $res=mysql_query("select * from h5_user where openid='".$openid."'");
    var_dump($res);
    echo "<br>";
    if(!$res){//如果不存在就插入
        $data["nowuserid"]= mysql_query($sql);
        var_dump($data["nowuserid"]);
        echo "<br>";
    }else{
        //如果存在就获取
        echo "该用户已经注册";
    }

}