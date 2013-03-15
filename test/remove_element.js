<html>
  <head>        
    <title>Test</title> 
            
    <script type="text/javascript">
    
    function removeElement(_element){
         var _parentElement = _element.parentNode;
         if(_parentElement){
                _parentElement.removeChild(_element);
         }
    }

    
    
    window.onload = function(){
        //alert("Test");
        var oDiv = document.getElementsByTagName("div");
        alert("befor updated::" + oDiv[3].id); 
        for(i=0;i<oDiv.length;i++){
            if(oDiv[i].id == "d"){
                //alert(i);
                removeElement(oDiv[i]);
                //alert("aaa");  
            } 
        } 
        alert("after updated::" + oDiv[3].id);
        
    }
    </script>
    
  </head>   
  <body>
  
  <div id="a" >aContent</div>
  <div id="b" >bContent</div>
  <div id="c" >cContent</div>
  <div id="d" >dContent</div>
  <div id="e" >eContent</div>
  
  </body>
</html>