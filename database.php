<?php
  set_time_limit(0); 
  include "mysql.php"; //conect to database
  include "functions.php";
  $geo = 'fi';
  $username = 'his36910';
  $password = 'Tao$$qi1';
  $choice = 'force';
  
  
  $authorization = get_headers_x($current_url, 0, $username, $password);
  
  if ( $authorization[0] == 'HTTP/1.1 401 Authorization Required'){
      echo 'wrong username and password combination.';
  }
  
  $results = mysql_query("SELECT * FROM jinge WHERE geo='fi'");
  $links = array();
   while( $row = mysql_fetch_row( $results )) {
         $links[] = $row[1];       
   }
  
   foreach ( $links as $link ){
       url($link, $geo);
   }
   echo "finish";
  
?>
