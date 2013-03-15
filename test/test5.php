<?php 
include "mysql.php"; //conect to database
$results = mysql_query("SELECT * FROM jinge WHERE geo='it'");
  $links = array();
   while( $row = mysql_fetch_row( $results )) {
         $links[] = $row[1];       
   }
   
   var_dump($links);
  ?>
