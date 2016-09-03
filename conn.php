<?php
//echo "db";
$db = mysql_connect(SAE_MYSQL_HOST_M.':'.SAE_MYSQL_PORT,SAE_MYSQL_USER,SAE_MYSQL_PASS);
if ($db) {
    mysql_select_db(SAE_MYSQL_DB, $db);
    mysql_query("set names 'utf8'");
  //  echo "dbok";
}