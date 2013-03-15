<?php 

function url ($url,$geo){
    
    $results = mysql_query("SELECT * FROM jinge WHERE link='$url' and geo='$geo'");
    $row = mysql_fetch_array($results);
    $force = $GLOBALS['choice'];
    
        if ( ($row != null) && ($force == 'normal') ){
            return $row['status'];
        }

        else {
            $link_status = url_status($url);
            
            //匹配adobe server
            $pattern1 = '/http:\/\/(www|author)\.(qa04\.|stage\.|corp\.)?adobe\.com/';
            preg_match($pattern1, $url, $matches1);
            switch ($link_status){
                case "fine":

                $geo_code = non_current_geo($url, $geo); 
                //如果此link localize过，那么正确
                if( $matches1 == null ){
                        if ( $row == null ){ 
                        mysql_query("INSERT INTO jinge (link, status, geo) VALUES ('$url', 'other', '$geo')");
                        }
                        else {
                        mysql_query("UPDATE jinge SET status = 'other' WHERE link = '$url' AND geo = '$geo'");
                        }
                       return 'other';
                }
                    
                else if ( stristr ( $url, "/$geo/") != null ){
                     if ( $row == null ){
                        mysql_query("INSERT INTO jinge (link, status, geo) VALUES ('$url', 'fine', '$geo')");
                     }
                     else{
                         mysql_query("UPDATE jinge SET status = 'fine' WHERE link = '$url' AND geo = '$geo'");
                     }
                    return 'fine';
                }
                
                //如果此link含有其他geo code
               
               else if ( $geo_code != null ){
                    //如果此geo code 为其parent geo,则带入自身geo测试，如果200则返回失败,如果404则返回成功
                   
                   
                   
                   $parent = find_parent($geo);
                 
                    
                    $pattern2 = "/(\/".$geo_code[2]."\/)\/?(.*)/";//匹配/<geo>/后面的
                    
                    preg_match($pattern2, $url, $matches2);
                    $new_url = $matches1[0].'/'.$geo.'/'.$matches2[2];
                    $new_status = url_status($new_url);
                        if ( $new_status == 'fine'){
                            if ( $row == null ){
                              mysql_query("INSERT INTO jinge (link, status, geo, suggestion) VALUES ('$url', 'broken', '$geo', '$new_url')");
                            }
                            else {
                              mysql_query("UPDATE jinge SET status = 'broken', suggestion = '$new_url' WHERE link = '$url' AND geo = '$geo'");
                            }
                            return 'broken';
                        }
                        //如果现geo是好的，替换的geo是坏的
                        else if ( $new_status == 'broken' ){
                            //如果替换的geo有父geo，那么正确,因为原link带有的geo为此page的父geo,而如果此link换乘子geo返回错误的花，说明只能用父geo,（则原link正确）。
                            if ( $geo_code[2] == $parent ){
                                  if ( $row == null ){
                                    mysql_query("INSERT INTO jinge (link, status, geo) VALUES ('$url', 'fine', '$geo')");
                                  }
                                   else {
                                    mysql_query("UPDATE jinge SET status = 'fine' WHERE link = '$url' AND geo = '$geo'");
                                   }
                                  return 'fine';
                            }
                            //如果替换成的geo根原link不为父子关系
                            else {
                        
                                if ($parent != null ){
                                $new_url2 = $matches1[0].'/'.$parent.'/'.$matches2[2]; //parent url
                                }
                                else{$new_url2 = $matches1[0].'/'.$matches2[2]; }
                                
                                $new_url3 = $new_url2 = $matches1[0].'/'.$matches2[2];;
                                
                                $new_status2 = url_status($new_url2);
                                $suggestion = ($new_status2 == 'fine')? $new_url2:$new_url3;
                                
                                if ( $row == null ){
                                    mysql_query("INSERT INTO jinge (link, status, geo, suggestion) VALUES ('$url', 'broken', '$geo', '$suggestion')");
                                }
                                else {
                                    mysql_query("UPDATE jinge SET status = 'broken', suggestion='$suggestion' WHERE link = '$url' AND geo = '$geo'");
                                }
                                
                                return 'broken';
 
                            }
                        }
                 
                }
 
                
                //如果此link为en站的,加入geo测试，如果200则返回失败，如果404则返回成功
                else {
                                      
                    $pattern2 = '/(.com)\/?(.*)/';//匹配http://www.adobe.com后面的                    
                    preg_match($pattern2, $url, $matches2);
                                       
                    $new_url = $matches1[0].'/'.$geo.'/'.$matches2[2];
                    $new_status = url_status($new_url);
                    
                    if ( $new_status == 'fine'){
                       if ( $row == null ){ 
                       mysql_query("INSERT INTO jinge (link, status, geo, suggestion) VALUES ('$url', 'broken', '$geo', '$new_url')");//不含/geo/的是错的，因为含/geo/的link是正确的
                       }
                       else {
                       mysql_query("UPDATE jinge SET status = 'broken', suggestion='$new_url' WHERE link = '$url' AND geo = '$geo'");

                       }
                       return 'broken'; //因为如果自己geo这个link是fine的而页面上的link用的是美国的link，那么用的link就是错的，所以要标broken
                    }
                    else if ( $new_status == 'broken' ){
                        
                        $parent = find_parent($geo);
                        if ( $parent != null ){
                            $new_url2 = $matches1[0].'/'.$parent.'/'.$matches2[2];
                            $new_status2 = url_status($new_url2);
                            if ( $new_status2 == 'fine' ){
                                if ( $row == null ){
                                  mysql_query("INSERT INTO jinge (link, status, geo, suggestion) VALUES ('$url', 'broken', '$geo'. '$new_url2')");
                                }
                                else{
                                  mysql_query("UPDATE jinge SET status = 'broken', suggestion='$new_url2' WHERE link = '$url' AND geo = '$geo'");

                                }
                                return "broken";
                            }
                            else {
                                if ($row == null ){
                                 mysql_query("INSERT INTO jinge (link, status, geo) VALUES ('$url', 'fine', '$geo')");
                                }
                                else{
                                 mysql_query("UPDATE jinge SET status = 'fine' WHERE link = '$url' AND geo = '$geo'");                             
                                }
                                return "fine";
                            }
                        }
                        
                        else {
                            if ($row == null ){
                            mysql_query("INSERT INTO jinge (link, status, geo) VALUES ('$url', 'fine', '$geo')");
                            }
                            else{
                            mysql_query("UPDATE jinge SET status = 'fine' WHERE link = '$url' AND geo = '$geo'");                             
                
                            }
                            return 'fine';//原因同上
                        }
                    }
                   
                }
                break;
                
                case "redirect":
                if ($row == null){    
                mysql_query("INSERT INTO jinge (link, status, geo) VALUES ('$url', 'redirect', '$geo')");
                }
                else{
                mysql_query("UPDATE jinge SET status = 'redirect' WHERE link = '$url' AND geo = '$geo'");                             

                }
                return 'redirect';
                break;
                
                case "broken":
                        //如果link broken且link带/<geo>/，去掉<geo>试验    
                if ( stristr ( $url, "/$geo/") != null ){
                    $pattern1 = '/http:\/\/(www|author)\.(qa04\.|stage\.|corp\.)?adobe\.com/';
                    $pattern2 = "/(\/".$geo."\/)\/?(.*)/";//匹配/<geo>/后面的
                    preg_match($pattern1, $url, $matches1);
                    preg_match($pattern2, $url, $matches2);
                    $parent = find_parent($geo);
                    if ( $parent == ''){
                         $new_url = $matches1[0].'/'.$matches2[2];
                    }
                    else {
                        $new_url = $matches1[0].'/'.$parent.'/'.$matches2[2]; 
                    }
                    
                    $new_status = url_status($new_url);
                    
                    if ( $new_status == 'fine'){
                        if ( $row == null){
                        mysql_query("INSERT INTO jinge (link, status, geo, suggestion) VALUES ('$url', 'broken', '$geo', '$new_url')");
                        }
                        else{
                        mysql_query("UPDATE jinge SET status = 'broken', suggestion='$new_url' WHERE link = '$url' AND geo = '$geo'");                             

                        }
                        return 'broken'; //测的link为broken,所以页面要显示broken.但是因为测试了新连接，所以要把新连接放到数据库
                    }
                    else if ( $new_status == 'broken' ){
                       $suggestion =  $matches1[0].'/'.$matches2[2];
                       if ( $row == null ){
                        mysql_query("INSERT INTO jinge (link, status, geo, suggestion) VALUES ('$url', 'broken', '$geo', '$suggestion')");
                       }
                       else{
                       mysql_query("UPDATE jinge SET status = 'broken', suggestion='$suggestion' WHERE link = '$url' AND geo = '$geo'");                             
 
                       }
                       return 'broken';//同上
                    }
                   
                }
                else {
                    if ($row == null){
                      mysql_query("INSERT INTO jinge (link, status, geo) VALUES ('$url', 'broken', '$geo')");
                    }
                    else{
                      mysql_query("UPDATE jinge SET status = 'broken' WHERE link = '$url' AND geo = '$geo'");                             
 
                    }
                    return 'broken';             
                }   
            }
      
    }
}

function url_status($url){
    
    $user = $GLOBALS['username'];
    $pass = $GLOBALS['password'];
    $pattern = '/http:\/\/(www|author)\.(qa04\.|stage\.|corp\.)?adobe\.com/';
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
