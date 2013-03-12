<?php
  //error_reporting(0);
  set_time_limit(0);
  include "mysql.php";
  $data_back = json_decode(file_get_contents('php://input'));
  $links = $data_back->links;
  $current_url = $data_back->current;
  $geo = 'dk';
  
/*save links array to a html file*/     
  $content = '';
  $content .= '<table><tr><th>links</th></tr>';
  
  foreach ( $links as $key=>$link ){
      $content .= '<tr><td>'.$key.'</td><td>'.$link.'</td></tr>';
  }
$content .= '</table>';


 $File = "adobe.html"; 
 $Handle = fopen($File, 'w'); 
 fwrite($Handle, $content); 

 fclose($Handle); 
/*************************************/

 
 foreach ( $links as $key=>$link ){
     
     $link_number = url ($link,$geo);
           $array[$key][0] = $links[$key];
           $array[$key][1] = $link_number;
           $array[$key][2] = $key;    
 }
 $array ['first_link'] = 0;
 $array ['last_link'] = count($links);
 
  
 echo  json_encode($array);


function url ($url,$geo){
    
    $results = mysql_query("SELECT * FROM jinge WHERE link='$url'");
    $row = mysql_fetch_array($results);
    
        if ( $row != null ){
            return $row['status'];
        }

        else {
            $link_status = url_status($url);
            
            switch ($link_status){
                case "fine":
                if ( stristr ( $url, "/$geo/") != null ){
                    mysql_query("INSERT INTO jinge (link, status, geo) VALUES ('$url', 'fine', '$geo')");
                    return 'fine';
                }
                
                else {
                    //如果在dk下，出现en的link，把/dk/加上去
                    $pattern1 = '/http:\/\/(www|author)\.(qa04\.|stage\.)?adobe\.com/';//匹配http://www.adobe.com之类
                    $pattern2 = '/(.com)\/?(.*)/';//匹配http://www.adobe.com后面的
                    preg_match($pattern1, $url, $matches1);
                    preg_match($pattern2, $url, $matches2);
                    $new_url = $matches1[0].'/'.$geo.'/'.$matches2[2];
                    $new_status = url_status($new_url);
                    
                    if ( $new_status == 'fine'){
                       mysql_query("INSERT INTO jinge (link, status, geo) VALUES ('$url', 'broken', '$geo')");//不含/geo/的是错的，因为含/geo/的link是正确的
                       mysql_query("INSERT INTO jinge (link, status, geo) VALUES ('$new_url', 'fine', '$geo')");
                       return 'broken'; //因为如果自己geo这个link是fine的而页面上的link用的是美国的link，那么用的link就是错的，所以要标broken
                    }
                    else if ( $new_status == 'broken' ){
                        mysql_query("INSERT INTO jinge (link, status, geo) VALUES ('$new_url', 'broken', '$geo')");
                        mysql_query("INSERT INTO jinge (link, status, geo) VALUES ('$url', 'fine', '$geo')");

                        return 'fine';//原因同上
                    }
                   
                }
                break;
                
                case "redirect":
                mysql_query("INSERT INTO jinge (link, status, geo) VALUES ('$url', 'redirect', '$geo')");
                return 'redirect';
                break;
                
                case "broken":
                //如果link broken且link带/<geo>/，去掉<geo>试验    
                if ( stristr ( $url, "/$geo/") != null ){
                    $pattern1 = '/http:\/\/(www|author)\.(qa04\.|stage\.)?adobe\.com/';
                    $pattern2 = '/(\/dk\/)\/?(.*)/';//匹配/<geo>/后面的
                    preg_match($pattern1, $url, $matches1);
                    preg_match($pattern2, $url, $matches2);
                    $new_url = $matches1[0].'/'.$matches2[2];
                    $new_status = url_status($new_url);
                    
                    if ( $new_status == 'fine'){
                        mysql_query("INSERT INTO jinge (link, status, geo) VALUES ('$url', 'broken', '$geo')");
                        mysql_query("INSERT INTO jinge (link, status, geo) VALUES ('$new_url', 'fine', '$geo')");
                       return 'broken'; //测的link为broken,所以页面要显示broken.但是因为测试了新连接，所以要把新连接放到数据库
                    }
                    else if ( $new_status == 'broken' ){
                        mysql_query("INSERT INTO jinge (link, status, geo) VALUES ('$new_url', 'broken', '$geo')");
                        mysql_query("INSERT INTO jinge (link, status, geo) VALUES ('$url', 'broken', '$geo')");
                        return 'broken';//同上
                    }
                   
                }
                else {               
                mysql_query("INSERT INTO jinge (link, status, geo) VALUES ('$url', 'broken', '$geo')");
                return 'broken';             
                }                     
                break;
            }
      

    }
}

function url_localize($url,$geo){
    $pattern = "/(.*\/)('$geo')\/?(.*)/";
    
    if ( !preg_match($pattern, $url, $matchs)){
        $pattern2 = '/(.com)\/?(.*)/';
        preg_match($pattern2, $url, $matchs2);
        $rest_url = $matchs2[2];
        
        $new_url = "http://www.adobe.com/".$geo."/".$rest_url;
        return $new_url;
    }
    else {
        return $url;
    }
}

function url_status($url){
    
    $header = get_headers($url);
            $status_num = explode ( ' ', $header[0]);
            $link_number = $status_num[1];
            if ( $link_number>199 && $link_number<300 ){
                return 'fine';
            }
            else if ($link_number>300 && $link_number<303){
                return 'redirect';
            }
            else if ( $link_number>400 && $link_number<500 ){
                return 'broken';
            }
}

?>