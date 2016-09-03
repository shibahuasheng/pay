<?php
session_start();
require_once "conn.php";
    $askid=$_GET['askid'];
    $sql="select * from H5_listen where askid=".$askid." and listenin_uid=".$_SESSION['nowuserid'];
    $res=mysql_query($sql);
    $data=array();
    if(mysql_num_rows($res)==0){
    	$data['state']=0;
    }else{
    	$data['state']=1;
    }
    echo json_encode($data);
	echo "\r\n<!--";