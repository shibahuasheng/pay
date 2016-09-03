<?php
require_once "conn.php";
$sql="select *,nickname from H5_answer,H5_user where answeruid=H5_user.id and askuid=".$_GET["uid"];
$res=mysql_query($sql);
$data=array();
$i=0;
while($row=mysql_fetch_array($res))
{
    $data[$i]=array();
    $data[$i]["id"]=$row["id"];
    $data[$i]["question"]=$row["question"];
    $data[$i]["flag"]=$row["flag"];
    $data[$i]["nickname"]=$row["nickname"];
    $data[$i]["asktime"]=$row["asktime"];
    $i++;
}
echo json_encode($data);
echo "\r\n<!--";
