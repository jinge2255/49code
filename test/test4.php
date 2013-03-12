<?php
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
$geo = "ch_de";
$url = "http://www.adobe.com/uk/asdasd";

$m = non_current_geo($url, $geo);
var_dump ($m);

?>
