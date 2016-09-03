<?php
 require_once "conn.php";
$ansserverid=$_GET["ansserverid"];
$sql="SELECT H5_answer.id as aid,headimgurl ,askuid,nickname,ansserverid,`question`,asktime,count,asktime FROM `H5_answer`,H5_user WHERE H5_answer.askuid=H5_user.id and ansserverid='".$ansserverid."'";
$res=mysql_query($sql);
$data=array();
$i=0;
while($row=mysql_fetch_array($res))
{$data[$i]=array();
    $data[$i]["aid"]=$row["aid"];
    $data[$i]["askuid"]=$row["askuid"];
    $data[$i]["nickname"]=$row["nickname"];
    $data[$i]["question"]=$row["question"];
    $data[$i]["asktime"]=$row["asktime"];
    $data[$i]["headimgurl"]=$row["headimgurl"];
    $data[$i]["ansserverid"]=$row["ansserverid"];
    $data[$i]["count"]=$row["count"];
    $data[$i]["asktime"]=$row["asktime"];
   $i++;
}
$sql2="SELECT H5_answer.id as aid,headimgurl ,askuid,nickname,ansserverid,`question`,asktime,count,asktime FROM `H5_answer`,H5_user WHERE H5_answer.answeruid=H5_user.id and ansserverid='".$ansserverid."'";
$res2=mysql_query($sql2);
$m=0;
while($row2=mysql_fetch_array($res2)){
    $data[$m]["aheadimgurl"]=$row2["headimgurl"];
    $data[$m]["anickname"]=$row2["nickname"];
   $m++; 
}
mysql_close();
echo json_encode($data);
echo "\r\n<!--";
