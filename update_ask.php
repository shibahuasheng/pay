<?php
 require_once "conn.php";
$sql="update H5_answer set flag=1,ansserverid='".$_GET["serverid"]."' where id=".$_GET["aid"];
//echo $sql;
$res=mysql_query($sql);
echo $res;