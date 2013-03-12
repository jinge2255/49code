<?php
$qa04 = "Only server 1: http://author.corp.adobe.com/crx/server has /etc/pagetables/products/adobe_fireworks_cs6_classroom_in_a_book/jcr:content\\cq:tags\\String[]: catalog:books/fireworksbooks_no,catalog:books/allbooks_nl,catalog:books/allbooks_uk,catalog:books/fireworksbooks_nl,catalog:books/allbooks,catalog:books/fireworksbooks_uk,catalog:books/allbooks_no
";
$author = "Only server 2: http://author.qa04.adobe.com/crx/server has /etc/pagetables/products/adobe_fireworks_cs6_classroom_in_a_book/jcr:content\\cq:tags\\String[]: catalog:books/fireworksbooks_ie,catalog:books/allbooks_dk,catalog:books/allbooks_ie,catalog:books/fireworksbooks_dk,catalog:books/fireworksbooks_be_fr,catalog:books/allbooks_uk,catalog:books/fireworksbooks_pt,catalog:books/allbooks_lu_en,catalog:books/allbooks_be_nl,catalog:books/allbooks_be_fr,catalog:books/fireworksbooks_no,catalog:books/allbooks_lu_fr,catalog:books/fireworksbooks_nl,catalog:books/allbooks_pt,catalog:books/allbooks_no,catalog:books/allbooks_be_en,catalog:books/fireworksbooks_fi,catalog:books/fireworksbooks_lu_de,catalog:books/fireworksbooks_be_nl,catalog:books/allbooks_lu_de,catalog:books/allbooks_nl,catalog:books/allbooks,catalog:books/fireworksbooks_lu_en,catalog:books/fireworksbooks_be_en,catalog:books/fireworksbooks_uk,catalog:books/allbooks_fi,catalog:books/fireworksbooks_lu_fr
";

$qa04_array = explode(',',$qa04);
$author_array = explode(',',$author);


echo "author has more:";
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