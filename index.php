<head>
<script type="text/javascript" src="jquery.js"></script>
<script type="text/javascript" src="ajax.js"></script>
<script type="text/javascript" src="fun.js"></script>
<script type="text/javascript" src="waytwo.js"></script>
</head>


<html>
    <h1>haha</h1>

       <p>asdsadqwwq</p> <a id="jinge" target="_blank" href="http://www.adobe.com/">adobe</a>
        <p>aaaaaaaaaaaaaa</p><a href="http://www.adobe.com/go/tryacrobatpro/">redirect</a>
       <p>ssssssssssssss</p> <a target="_blank" href="http://www.adobe.com/dk/products/">dk products</a>
        <p>ddddddddddd</p> <a target="_blank" href="http://www.adobe.com/products/catalog.html">en products</a>
         <p>ffffffffffff</p> <a target="_blank" href="http://www.adobe.com/dk/products/color-lava.html">dk lava</a>


<button onclick="funphp100()">test</button>
<button onclick="way('force')">force</button>
<button onclick="way('normal')">normal</button>
<br>


<div id="jinge_jinge"></div>
</html>

<?php
include "mysql.php";
$result = mysql_query("SELECT * FROM jinge WHERE status='finee'");

while($row = mysql_fetch_array($result))
  {
  echo $row['link'] . " " . $row['status'];
  echo "<br />";
  }
  if ( $row == null ){
      echo 'asd';
  }
?>