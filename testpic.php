<?php
$url = 'http://www.h5edu.cn/Public/assets/img/logo_blue.png';  
  
    function http_get_data($url) {  
          
        $ch = curl_init ();  
        curl_setopt ( $ch, CURLOPT_CUSTOMREQUEST, 'GET' );  
        curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, false );  
        curl_setopt ( $ch, CURLOPT_URL, $url );  
        ob_start ();  
        curl_exec ( $ch );  
        $return_content = ob_get_contents ();  
        ob_end_clean ();  
          
        $return_code = curl_getinfo ( $ch, CURLINFO_HTTP_CODE );  
        return $return_content;  
    }  
      
    $return_content = http_get_data($url);  
$filename = 'pic/logo.jpg';  
    $fp= @fopen($filename,"a"); //将文件绑定到流    
    fwrite($fp,$return_content); //写入文件
  echo "ok";
?>