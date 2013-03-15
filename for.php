<?php
  //error_reporting(0);
  set_time_limit(0); 
  include "mysql.php"; //conect to database
  include "functions.php";
  $data_back = json_decode(file_get_contents('php://input')); //get data from firefox-extension
  $links = $data_back->links; //all urls in the page
  $current_url = $data_back->current; //current link of the page
  $username = $data_back->username;
  $password = $data_back->password;
  $choice = $data_back->choice;

  
  $authorization = get_headers_x($current_url, 0, $username, $password);
  
  if ( $authorization[0] == 'HTTP/1.1 401 Authorization Required'){
      echo 'wrong username and password combination.';
  }
  
  else {
  


        $stop_at = count($links)-121; //

        //find geo
        $pattern = "/(\/(uk|sk|si|ee|bg|de|at|ch_de|lu_de|cz|ro|tr|se|no|dk|fi|br|pt|hu|hr|rs|mena_en|mena_ar|ru|ua|pl|lv|cn|tw|hk_zh|hk_en|ca|kr|sea|ap|au|nz|in|it|nl|ch_it|be_nl|eeurope|ie|be_en|lu_en|africa|es|la|mx|il_he|il_en|fr|be_fr|lu_fr|mena_fr|ch_fr|ca_fr|jp)\/)/";
        preg_match($pattern, $current_url, $find_geo);
        if ( $find_geo != null ){
            $geo = $find_geo[2];
        }
        else {
            $geo = 'en';
        }


        for ($i = 128; $i<$stop_at; $i++){
                   if ( $links[$i] != null ){
                      $status = url($links[$i],$geo);
                   }
                       $array[$i][0] = $links[$i];
                       $array[$i][1] = $status;
                       $array[$i][2] = $i;

        } 

        $array ['first_link'] = 128;
        $array ['last_link'] = $stop_at;


        echo  json_encode($array);
  }

?>