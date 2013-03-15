<?php
  set_time_limit(0);
  include "mysql.php";
  $username = 'his36910';
  $password = 'xxxx';
  if ( $_GET['submit']){
        $geo = $_GET['geo'];

        $url = $_GET['url']; 
        echo  url($url,$geo);
        echo "<br>";
        echo "url:".$url;
        echo "<br>";
        echo "geo:".$geo;
        echo "<br>";
  }

function url ($url,$geo){
    
    $results = mysql_query("SELECT * FROM jinge WHERE link='$url' and geo='$geo'");
    $row = mysql_fetch_array($results);
    
        if ( $row != null ){
            return $row['status'];
        }

        else {
            $link_status = url_status($url);
            
            //匹配adobe server
            $pattern1 = '/http:\/\/(www|author)\.(qa04\.|stage\.)?adobe\.com/';
            preg_match($pattern1, $url, $matches1);
            //看link是author.adobe还是www.adobe
            $author = '';
              if ( $matches1 != null && stristr($matches1[0], "author")){
                  $author = 'author';
              }
     
            switch ($link_status){
                case "fine":
                $geo_code = non_current_geo($url, $geo); 
                //如果为非adobe域名的，那么other
                if( $matches1 == null ){
                     mysql_query("INSERT INTO jinge (link, status, geo) VALUES ('$url', 'other', '$geo')");
                    return 'other';
                }
                   //如果此link localize过，那么正确 
                else if ( stristr ( $url, "/$geo/") != null ){
                    mysql_query("INSERT INTO jinge (link, status, geo) VALUES ('$url', 'fine', '$geo')");
                    return 'fine';
                }
                
                //如果此link含有其他geo code，并且此geo code为此页面的parent geo.则测试其子geo.
               
               else if ( $geo_code != null ){
                    //如果此geo code 为其parent geo,则带入自身geo测试，如果200则返回失败,如果404则返回成功
                   $parent = find_parent($geo);
                   if ( $geo_code[2] == $parent ){
                    
                    $pattern2 = "/(\/".$parent."\/)\/?(.*)/";//匹配/<geo>/后面的
                    
                    preg_match($pattern2, $url, $matches2);
                    $new_url = $matches1[0].'/'.$geo.'/'.$matches2[2];
                    $new_status = url_status($new_url);
                        if ( $new_status == 'fine'){
                            mysql_query("INSERT INTO jinge (link, status, geo, suggestion) VALUES ('$url', 'broken', '$geo', '$new_url')");
                            return 'broken';
                        }
                        //如果现geo是好的，替换的子geo是坏的，那么返回正确
                        else if ( $new_status == 'broken' ){
                            mysql_query("INSERT INTO jinge (link, status, geo) VALUES ('$url', 'fine', '$geo')");
                            return 'fine';
                        }
                   }
                   //如果此geo code不为其parent，返回失败
                   else {
                       return 'broken';
                   }
                }
 
                
                //如果此link为en站的,加入geo测试，如果200则返回失败，如果404则返回成功
                else {
                                      
                    $pattern2 = '/(.com)\/?(.*)/';//匹配http://www.adobe.com后面的                    
                    preg_match($pattern2, $url, $matches2);
                                       
                    $new_url = $matches1[0].'/'.$geo.'/'.$matches2[2];
                    $new_status = url_status($new_url);
                    
                    if ( $new_status == 'fine'){
                       mysql_query("INSERT INTO jinge (link, status, geo, suggestion) VALUES ('$url', 'broken', '$geo', '$new_url)");//不含/geo/的是错的，因为含/geo/的link是正确的
                       return 'broken'; //因为如果自己geo这个link是fine的而页面上的link用的是美国的link，那么用的link就是错的，所以要标broken
                    }
                    else if ( $new_status == 'broken' ){
                        
                        $parent = find_parent($geo);
                        //如果此geo有parent则带parent测试
                        if ( $parent != null ){
                            $new_url2 = $matches1[0].'/'.$parent.'/'.$matches2[2];
                            $new_status2 = url_status($new_url2);
                            if ( $new_status2 == 'fine' ){
                                mysql_query("INSERT INTO jinge (link, status, geo, suggestion) VALUES ('$url', 'broken', '$geo'. '$new_url2')");
                                return "broken";
                            }
                            else {
                                 mysql_query("INSERT INTO jinge (link, status, geo) VALUES ('$url', 'fine', '$geo')");
                                return "fine";
                            }
                        }
                        
                        else {
                            mysql_query("INSERT INTO jinge (link, status, geo) VALUES ('$url', 'fine', '$geo')");

                            return 'fine';//原因同上
                        }
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
                    $pattern2 = "/(\/".$geo."\/)\/?(.*)/";//匹配/<geo>/后面的
                    preg_match($pattern1, $url, $matches1);
                    preg_match($pattern2, $url, $matches2);
                    $new_url = $matches1[0].'/'.$matches2[2];
                    $new_status = url_status($new_url);
                    
                    if ( $new_status == 'fine'){
                        mysql_query("INSERT INTO jinge (link, status, geo, suggestion) VALUES ('$url', 'broken', '$geo', '$new_url')");
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
            }
      
    }
}

function url_status($url){
    
    $user = $GLOBALS['username'];
    $pass = $GLOBALS['password'];
    $pattern = '/http:\/\/(www|author)\.(qa04\.|stage\.)?adobe\.com/';
    preg_match($pattern, $url, $matches);
    
    if ( $matches != null && stristr($matches[0], "author")){
        $header = get_headers_x($url, 0, $user, $pass);
    }
        else{

        $header = get_headers($url);
        }
        
    if ( $header == FALSE){
        return 'broken';
    }
    else {
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
}

function find_parent($geo){
    
        switch ($geo){
        case "ch_de": case "lu_de": case "at":
        return "de";
            break;
        case "ca_fr": case "lu_fr": case "be_fr": case "mena_fr":case "ch_fr":
        return "fr"; 
            break;
        case "ch_it":
        return "it";
            break;
        case "be_nl";
        return "nl";
            break;
        case "bg": case "cz": case "ee": case "hr": case "hu": case "lt": case "lv": 
        case "pl": case "ro": case "rs": case "sk": case "si": case "tr": case "ua":
        return "eeurope";
            break;
        default :
            return "";
            break;
    }
}

function non_current_geo($url,$geo){

$pattern = "/(\/(uk|sk|si|ee|bg|de|at|ch_de|lu_de|cz|ro|tr|se|no|dk|fi|br|pt|hu|hr|rs|mena_en|mena_ar|ru|ua|pl|lv|cn|tw|hk_zh|hk_en|ca|kr|sea|ap|au|nz|in|it|nl|ch_it|be_nl|eeurope|ie|be_en|lu_en|africa|es|la|mx|il_he|il_en|fr|be_fr|lu_fr|mena_fr|ch_fr|ca_fr|jp)\/)/";

if ( $geo == 'uk'){
    $subject = "/(uk\|)/";
}
else {
    $subject = "/\|$geo/";
}
$replace = preg_replace($subject, "", $pattern);

preg_match($replace, $url, $matches);
        
return $matches;

}



    function get_headers_x($url,$format=0, $user='', $pass='') {
        
        if (!empty($user)) {
            $authentification = base64_encode($user.':'.$pass);
            $authline = "Authorization: Basic $authentification\r\n";
        }

        $url_info=parse_url($url);
        $port = isset($url_info['port']) ? $url_info['port'] : 80;
        $fp=fsockopen($url_info['host'], $port, $errno, $errstr, 30);
        if($fp) {
            $head = "GET ".@$url_info['path']."?".@$url_info['query']." HTTP/1.0\r\n";
            if (!empty($url_info['port'])) {
                $head .= "Host: ".@$url_info['host'].":".$url_info['port']."\r\n";
            } else {
                $head .= "Host: ".@$url_info['host']."\r\n";
            }
            $head .= "Connection: Close\r\n";
            $head .= "Accept: */*\r\n";
            $head .= $authline;
            $head .= "\r\n";

            fputs($fp, $head);       
            while(!feof($fp) or ($eoheader==true)) {
                if($header=fgets($fp, 1024)) {
                    if ($header == "\r\n") {
                        $eoheader = true;
                        break;
                    } else {
                        $header = trim($header);
                    }

                    if($format == 1) {
                    $key = array_shift(explode(':',$header));
                        if($key == $header) {
                            $headers[] = $header;
                        } else {
                            $headers[$key]=substr($header,strlen($key)+2);
                        }
                    unset($key);
                    } else {
                        $headers[] = $header;
                    }
                } 
            }
            return $headers;

        } else {
            return false;
        }
    }
?>
<form>
    <form name="input" action="" method="get">
GEO: <input type="text" name="geo">
URL: <input type="text" size ="100" name="url">
<input type="submit" value="Submit" name="submit">
</form> 
