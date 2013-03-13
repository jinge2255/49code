<?php

set_time_limit(0);
$a = array ('http://www.adobe.com/go/tryacrobatpro/','http://www.adobe.com/go/tryacrobatpro/','http://www.adobe.com/go/tryacrobatpro/','http://www.adobe.com/go/tryacrobatpro/'
          ,'http://www.adobe.com/go/tryacrobatpro/','http://www.adobe.com/go/tryacrobatpro/',
    'http://www.adobe.com/go/tryacrobatpro/',
    'http://www.adobe.com/go/tryacrobatpro/',
    'http://www.adobe.com/go/tryacrobatpro/');

foreach ($a as $b){
    get_headers($b);
}
?>
