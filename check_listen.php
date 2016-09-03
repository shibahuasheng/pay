<?php
session_start();
require_once "conn.php";
    $askid=$_GET['askid'];
    $count=$_GET['count'];
    $sql="update H5_answer set count='".$count."' where id=".$askid;
//echo $sql;
	$res=mysql_query($sql);
	$sql2="insert into H5_listen (listenin_uid,askid) values (".$_SESSION['nowuserid'].",".$askid.")";
	$res=mysql_query($sql2);
    // @session_start();
    // $sql3="select * from H5_listen where askid=".$askid;
    // $res3=mysql_query($sql3);
    // $row=mysql_fetch_array($res3);
    // $_SESSION["listenid"]=$row["id"];

