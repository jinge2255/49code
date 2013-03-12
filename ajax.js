
var xmlHttp;
function S_xmlhttprequest() {
	if(window.ActiveXObject) {
		xmlHttp = new ActiveXObject('Microsoft.XMLHTTP');
	} else if(window.XMLHttpRequest) {
		xmlHttp = new XMLHttpRequest();
	}
}

function funphp100() {
	S_xmlhttprequest();
       // var url = document.myform.user.value;
         var allLinks = document.getElementsByTagName("a");
         var elm=new Array();										
        for (var i=0, il=allLinks.length; i<il; i++) {
                elm[i] = allLinks[i];

        }
       
       var person = {};
            person.links = elm.toString();

       var str = JSON.stringify(person);

	xmlHttp.open("GET","for.php?id="+str,true);
	xmlHttp.onreadystatechange = byphp;
	xmlHttp.send(null);
}

function byphp() {
    
//    			var head = document.getElementsByTagName("head")[0],
//				style = document.getElementById("link-target-finder-style"),
//				myLinks = document.getElementsByTagName("a");
////				foundLinks = 0;
//			
//			if (!style) {
//				style = document.createElement("link");
//				style.id = "link-target-finder-style";
//				style.type = "text/css";
//				style.rel = "stylesheet";
//				style.href = "skin_jin2.css";
//				head.appendChild(style);
//			}	
						
//			for (var i=0, il=allLinks.length; i<il; i++) {
//				elm = allLinks[i];
//				if (elm.getAttribute("target")) {
//					elm.className += ((elm.className.length > 0)? " " : "") + "link-target-finder-selected";
//					foundLinks++;
//				}
//			}

//  	if(xmlHttp.readyState == 1) {
//		 document.getElementById('php100').innerHTML = "loading....";
//	}
//
          var byphp100 =  xmlHttp.responseText;
//          var links = JSON.parse(byphp100);
//         
//          
//          for (var f=0, fl=4; f<fl; f++){
//              fine = links.fine[f];
//              broken = links.broken[f];
//              redirect = links.redirect[f];
//               for ( var i = 0, il = myLinks.length; i<il; i++)
//               {
//                   if (myLinks[i] == broken){
//                       myLinks[i].className += ((myLinks[i].className.length > 0)? " " : "") + "link-target-finder-selected_2";
//                   }
//                   else if ( myLinks[i] == redirect ){
//                       myLinks[i].className += ((myLinks[i].className.length > 0)? " " : "") + "link-target-finder-selected";
//                   }
////                   else if ( myLinks[i] == broken ){
////                       myLinks[i].className += ((myLinks[i].className.length > 0)? " " : "") + "link-target-finder-selected";
////                   }
//               }
//          }
          
//          for (var r=0, rl=contact.redirect.length; r<rl; r++){
//              elm2 = contact.redirect[r];
//               for ( var j = 0, jl = myLinks.length; j<jl; j++)
//               {
//                   if (myLinks[j] == elm2){
//                       myLinks[j].className += ((myLinks[j].className.length > 0)? " " : "") + "link-target-finder-selected";
//                   }
//               }
//          }

                           
          document.getElementById('php100').innerHTML = byphp100;
//          alert (contact.fine.length);


	}







