<?php

// 连主库
$db = mysql_connect(SAE_MYSQL_HOST_M.':'.SAE_MYSQL_PORT,SAE_MYSQL_USER,SAE_MYSQL_PASS);
if ($db) {
    mysql_select_db(SAE_MYSQL_DB, $db);
   echo "ok";
    $sql="insert into test (id) values (888)";
    mysql_query($sql);
    echo "ok2";
    $res=mysql_query("select * from test");
    while($row=mysql_fetch_array($res)){
     var_dump($row);
    }
}

?>