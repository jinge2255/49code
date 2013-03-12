var div_container = null;

function mouseover(id){
 var newdiv = document.createElement("div");
 var newcontent = document.createElement("p");
 
 newdiv.appendChild(newcontent);
 div_container = document.getElementById(id);//新建div应该放的位置
 div_container.appendChild(newdiv);
}
