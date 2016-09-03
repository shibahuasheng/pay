<?php
 require_once "conn.php";
$uid=$_POST["uid"];
$touid=$_POST["touid"];
$question=$_POST["question"];
$nowtime=date('Y-m-d H:i:s');
//echo $nowtime;
$sql="insert into H5_answer (question,askuid,asktime,flag,answeruid,count) values
                   ('$question',$uid,'$nowtime',0,$touid,0)";
$res=mysql_query($sql);
echo "ok";
