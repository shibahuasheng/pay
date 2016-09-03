<?php
require_once "conn.php";
$sql="select * from H5_user where type=1";
$res=mysql_query($sql);
//echo "查询结果".$res;
$data=array();
$i=0;
while($row=mysql_fetch_array($res))
{
    $data[$i]=array();
    $data[$i]["id"]=$row["id"];
    $data[$i]["nickname"]=$row["nickname"];
    $data[$i]["headimgurl"]=$row["headimgurl"];
    $i++;
}
echo json_encode($data);
echo "\r\n<!--";
?>