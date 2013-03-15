<?php
$url = "http://www.adobe.com/";
$pattern2 = '/(.com)\/?(.*)/';//匹配http://www.adobe.com后面的                    
preg_match($pattern2, $url, $matches2);

var_dump($matches2);
?>
