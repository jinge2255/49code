
var xmlHttp;
function S_xmlhttprequest() {
    if(window.ActiveXObject) {
        xmlHttp = new ActiveXObject('Microsoft.XMLHTTP');
    } else if(window.XMLHttpRequest) {
        xmlHttp = new XMLHttpRequest();
    }
}

function way() {
    S_xmlhttprequest();
    

var elm = [];
    var links = document.getElementsByTagName('a');
    var currenturl = document.URL;
    var username = 'his36910';
    var password = 'Tao$$qi1';
    il=links.length;
    
    for( var i=0; i<il; i++) {
        
        href = links[i].href;
        urlArr = href.split("?");
        
       // console.log(urlArr[0]);
         
        elm.push(urlArr[0]);
    }
    
     var person = {};
         person.links = elm;
         person.current = currenturl;
//         person.username = username;
//         person.password = password;

    
    var data=JSON.stringify(person);
    console.log(data);
  

    xmlHttp.open("POST","http://localhost/49code/for2.php",false);  
    //xmlHttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded'); 
    xmlHttp.setRequestHeader("Content-Type", "application/json; charset=utf-8");
    xmlHttp.setRequestHeader("Content-Length", data.length);
    xmlHttp.onreadystatechange = byphp; 
    xmlHttp.send(data);
     

}

function byphp() {

						                      
    if (xmlHttp.readyState == 4) {
   var byphp100 =  xmlHttp.responseText;
        links_bk = JSON.parse(byphp100);
        length_object = Object.keys(links_bk).length;
        frist_link = links_bk['first_link'];
        last_link = links_bk['last_link'];
        
        
    			var head = document.getElementsByTagName("head")[0],
				style = document.getElementById("link-target-finder-style"),
				allLinks = document.getElementsByTagName("a");

			
			if (!style) {
				style = document.createElement("link");
				style.id = "link-target-finder-style";
				style.type = "text/css";
				style.rel = "stylesheet";
				style.href = "skin_jin3.css";
				head.appendChild(style);
			}	
			
 
 
			for (var i=frist_link; i<last_link; i++) {
				elm = allLinks[i];
                                status = links_bk[i][1];
                                
				if (status == 'fine') {
                                        console.log(elm);
					elm.className += ((elm.className.length > 0)? " " : "") + "link-target-finder-selected";
				}
                                else if (status == 'redirect'){
                                    console.log(elm);
                                        elm.className += ((elm.className.length > 0)? " " : "") + "link-target-finder-selected-redirect";
                                }
                                else if (status == 'broken'){
                                    console.log(elm);
                                        elm.className += ((elm.className.length > 0)? " " : "") + "link-target-finder-selected-broken";
                                }
                                  else if (status == 'other'){
                                    console.log(elm);
                                        elm.className += ((elm.className.length > 0)? " " : "") + "link-target-finder-selected-other";
                                }
			}

    }

            
     
}







