<?php
require_once "conn.php";
$sql="select *,nickname from H5_answer,H5_user,H5_listen where H5_listen.askid=H5_answer.id and H5_answer.answeruid=H5_user.id and listenin_uid=".$_GET["uid"];
$res=mysql_query($sql);
$data=array();
$i=0;
while($row=mysql_fetch_array($res))
{
    $data[$i]=array();
    $data[$i]["id"]=$row["id"];
    $data[$i]["question"]=$row["question"];
    $data[$i]["count"]=$row["count"];
    $data[$i]["nickname"]=$row["nickname"];
    $data[$i]["asktime"]=$row["asktime"];
    $i++;
}
echo json_encode($data);
echo "\r\n<!--";