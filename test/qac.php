<?php
$qa04 = "Only server 1: http://author.qa02.adobe.com/crx/server has /etc/pagetables/products/AcrobatComCreatePDF/jcr:content\\cq:tags\\String[]: catalog:software/acrobatcollection_be_en,catalog:services/allservices_it,catalog:services/allservices_nl,catalog:services/allservices_no,catalog:software/acrobatcollection_de,catalog:software/acrobatcollection_ch_de,catalog:software/acrobatcollection_dk,catalog:education/alledu_se,catalog:education/alledu_fr,catalog:services/allservices_be_en,catalog:education/alledu_be_en,catalog:services/allservices_fr,catalog:services/allservices_au,catalog:services/allservices_jp,catalog:education/alledu_jp,catalog:education/alledu_au,catalog:software/acrobatcollection_se,catalog:education/alledu_nl,catalog:services/allservices_be_nl,catalog:education/alledu_no,catalog:software/acrobatcollection_au,catalog:services/allservices_be_fr,catalog:software/acrobatcollection_ch_fr,catalog:services/allservices,catalog:education/alledu_it,catalog:education/alledu_be_fr,catalog:software/acrobatcollection_be_nl,catalog:education/alledu_be_nl,catalog:software/acrobatcollection_fr,catalog:software/acrobatcollection_nl,catalog:education/alledu_ch_it,catalog:software/acrobatcollection_jp,catalog:education/alledu_uk,catalog:software/acrobatcollection_no,catalog:services/allservices_ch_fr,catalog:software/acrobatcollection_be_fr,catalog:services/allservices_de,catalog:education/alledu_dk,catalog:services/allservices_dk,catalog:education/alledu_de,catalog:education/alledu,catalog:software/acrobatcollection_it,catalog:services/allservices_ch_de,catalog:services/allservices_ch_it,catalog:services/allservices_se,catalog:education/alledu_ch_de,catalog:education/alledu_ch_fr,catalog:software/acrobatcollection_ch_it,catalog:software/acrobatcollection_uk,catalog:software/acrobatcollection"; 
$author = "Only server 2: http://author.qa04.adobe.com/crx/server has /etc/pagetables/products/AcrobatComCreatePDF/jcr:content\\cq:tags\\String[]: catalog:education/alledu_pl,catalog:software/acrobatcollection_be_en,catalog:services/allservices_it,catalog:software/acrobatcollection_cz,catalog:services/allservices_es,catalog:services/allservices_nl,catalog:software/acrobatcollection_pl,catalog:services/allservices_no,catalog:software/acrobatcollection_de,catalog:software/acrobatcollection_ch_de,catalog:software/acrobatcollection_dk,catalog:services/allservices_nz,catalog:education/alledu_se,catalog:software/acrobatcollection_br,catalog:education/alledu_fr,catalog:services/allservices_be_en,catalog:services/allservices_fi,catalog:education/alledu_be_en,catalog:services/allservices_fr,catalog:education/alledu_fi,catalog:services/allservices_au,catalog:services/allservices_jp,catalog:services/allservices_at,catalog:education/alledu_jp,catalog:education/alledu_nz,catalog:education/alledu_au,catalog:education/alledu_at,catalog:software/acrobatcollection_se,catalog:education/alledu_no,catalog:services/allservices_be_nl,catalog:software/acrobatcollection_at,catalog:services/allservices_pl,catalog:services/allservices_be_fr,catalog:software/acrobatcollection_au,catalog:software/acrobatcollection_ch_fr,catalog:services/allservices,catalog:software/acrobatcollection_es,catalog:education/alledu_be_fr,catalog:education/alledu_it,catalog:software/acrobatcollection_be_nl,catalog:education/alledu_be_nl,catalog:services/allservices_br,catalog:software/acrobatcollection_fr,catalog:software/acrobatcollection_nl,catalog:education/alledu_ch_it,catalog:software/acrobatcollection_jp,catalog:education/alledu_uk,catalog:software/acrobatcollection_no,catalog:software/acrobatcollection_fi,catalog:education/alledu_es,catalog:software/acrobatcollection_nz,catalog:education/alledu_br,catalog:services/allservices_ch_fr,catalog:software/acrobatcollection_be_fr,catalog:services/allservices_de,catalog:education/alledu_dk,catalog:services/allservices_dk,catalog:education/alledu_de,catalog:education/alledu,catalog:software/acrobatcollection_it,catalog:services/allservices_ch_de,catalog:services/allservices_ch_it,catalog:services/allservices_se,catalog:education/alledu_ch_de,catalog:services/allservices_cz,catalog:education/alledu_ch_fr,catalog:software/acrobatcollection_ch_it,catalog:software/acrobatcollection_uk,catalog:software/acrobatcollection,catalog:education/alledu_cz,catalog:education/alledu_nl,catalog:software/acrobatcollection_ie,catalog:education/alledu_ie,catalog:services/allservices_ie,catalog:software/acrobatcollection_africa,catalog:services/allservices_africa,catalog:software/acrobatcollection_eeurope,catalog:services/allservices_eeurope,catalog:software/acrobatcollection_bg,catalog:services/allservices_bg,catalog:software/acrobatcollection_pt,catalog:services/allservices_pt,catalog:education/alledu_pt,catalog:software/acrobatcollection_ee,catalog:services/allservices_ee,catalog:services/allservices_lv,catalog:software/acrobatcollection_lv,catalog:software/acrobatcollection_lu_en,catalog:software/acrobatcollection_lu_de,catalog:software/acrobatcollection_ro,catalog:software/acrobatcollection_hu,catalog:education/alledu_lu_en,catalog:education/alledu_lu_de,catalog:services/allservices_lu_en,catalog:services/allservices_lu_de,catalog:services/allservices_hu,catalog:services/allservices_ro,catalog:services/allservices_lu_fr,catalog:education/alledu_lu_fr,catalog:software/acrobatcollection_lu_fr,catalog:services/allservices_lt,catalog:software/acrobatcollection_lt,catalog:services/allservices_sk,catalog:software/acrobatcollection_sk,catalog:services/allservices_si,catalog:software/acrobatcollection_si";

$qa04_array = explode(',',$qa04);
$author_array = explode(',',$author);

echo "qa02 has more:";
echo "<br>";
foreach ( $qa04_array as $key1=>$value1){
    if ($key1 == 0){
        $qa04_0 = explode('[]: ',$value1);
        echo $qa04_0[0];
        echo "<br>";
        if (stristr($author,$qa04_0[1])){
            echo "";
        }
        else {
            echo $qa04_0[1];
             echo "<br>";
        }
    }
    else{
                if (stristr($author,$value1)){
            echo "";
        }
        else {
            echo $value1;
            echo "<br>";
        }
    }
}
echo "<br>";
echo "qa04 has more:";
echo "<br>";
foreach ( $author_array as $key2=>$value2){
    if ($key2 == 0){
        $author_0 = explode('[]: ',$value2);
        echo $author_0[0];
        echo "<br>";
        if (stristr($qa04,$author_0[1])){
            echo "";
        }
        else {
            echo $author_0[1];
            echo "<br>";
        }
    }
    else{
                if (stristr($qa04,$value2)){
            echo "";
        }
        else {
            echo $value2;
            echo "<br>";
        }
    }
}

echo "<br>";
echo "what author has and qa04 also has:";
echo "<br>";
foreach ( $qa04_array as $key1=>$value1){
    if ($key1 == 0){
        $qa04_0 = explode('[]: ',$value1);
        if (stristr($author,$qa04_0[1])){
             echo $qa04_0[1];
             echo "<br>";
        }
        else {
           echo "";
        }
    }
    else{
                if (stristr($author,$value1)){
            echo $value1;
            echo "<br>";
        }
        else {
            echo "";
           
        }
    }
}

?>