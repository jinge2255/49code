<?php
$geo = "dk";
$pattern = "/(\/dk\/)/";
$string = "http://webcheatsheet.com/dk/regular_expressions.php";

if (preg_match($pattern, $string, $matches)) {
  echo "Match was found <br />";
  
  $geo = $matches[0];
  echo $geo;
   echo "<br>";
}
else {
   $geo = 'en';
   echo $geo;
   echo "<br>";
}

$m = "/(\/";
$n = "dk";
$v = "\/)\/?(.*)/";
$comb = $m.$n.$v;
echo $comb;
echo "<br>";
$jin = "/(\/".$geo."\/)\/?(.*)/";
echo $jin;

$a = "/(\/dk\/)\/?(.*)/";
$b = 'http://www.adobe.com/dk/qqq/dsadasd.html';

preg_match($comb, $b, $c);
var_dump($c);

                    $url = "http://www.adobe.com/dk/products/acrobat.html";
                    $geo = "dk";
//                    $pattern1 = '/http:\/\/(www|author)\.(qa04\.|stage\.)?adobe\.com/';
//                    $pattern2 = '/(.com)\/?(.*)/';
//                    preg_match($pattern1, $url, $matches1);
//                    preg_match($pattern2, $url, $matches2);
//                    $url = $matches1[0].'/'.$geo.'/'.$matches2[2];
//                    echo $url;
                    
                    $pattern1 = '/http:\/\/(www|author)\.(qa04\.|stage\.)?adobe\.com/';
                    $pattern2 = '/(\/dk\/)\/?(.*)/';//匹配/<geo>/后面的
                    preg_match($pattern1, $url, $matches1);
                    preg_match($pattern2, $url, $matches2);
                    $new_url = $matches1[0].'/'.$matches2[2];
                    echo $new_url;
?>