<?php
  //error_reporting(0);
  set_time_limit(0); 
  include "mysql.php"; //conect to database
  $data_back = json_decode(file_get_contents('php://input')); //get data from firefox-extension
  $links = $data_back->links; //all urls in the page
  $current_url = $data_back->current; //current link of the page
  
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

 $stop_at = count($links)-121; //
 
 for ($i = 128; $i<$stop_at; $i++){
   
            $link_number = url($links[$i]);
            
                $array[$i][0] = $links[$i];
                $array[$i][1] = $link_number;
                $array[$i][2] = $i;
 
 } 
 
 $array ['first_link'] = 128;
 $array ['last_link'] = $stop_at;
 
  
 echo  json_encode($array);



function url ($url){
    
    $results = mysql_query("SELECT * FROM nl WHERE link='$url'");
    $row = mysql_fetch_array($results);
    
        if ( $row != null ){
            return $row['status'];
        }

        else {
            $header = get_headers($url);
            $status_num = explode ( ' ', $header[0]);
            $link_number = $status_num[1];

           if ( $link_number>199 && $link_number<300 ){               
            mysql_query("INSERT INTO nl (link, status) VALUES ('$url', 'fine')");
               return 'fine';
           }
           else if ( $link_number>300 && $link_number<310 ){
               mysql_query("INSERT INTO nl (link, status) VALUES ('$url', 'redirect')");
               return 'redirect';
           }
           else if ( $link_number>400 && $link_number<500 ){
                mysql_query("INSERT INTO nl (link, status) VALUES ('$url', 'broken')");
               return 'broken';
        }
        else {
               mysql_query("INSERT INTO nl (link, status) VALUES ('$url', 'empty')");
               return 'fine';
        }

    }
}






?>