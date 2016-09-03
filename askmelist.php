<?php
require_once "conn.php";
$sql="select *,nickname,H5_answer.id as aid from H5_answer,H5_user where askuid=H5_user.id and answeruid=".$_GET["uid"];
$res=mysql_query($sql);
$data=array();
$i=0;
while($row=mysql_fetch_array($res))
{
    $data[$i]=array();
    $data[$i]["id"]=$row["aid"];
    $data[$i]["question"]=$row["question"];
    $data[$i]["flag"]=$row["flag"];
    $data[$i]["nickname"]=$row["nickname"];
    $data[$i]["asktime"]=$row["asktime"];
    $i++;
}
echo json_encode($data);
echo "\r\n<!--";
