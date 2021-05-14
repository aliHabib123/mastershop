
function showReturnedMessage(divId){
	 	document.getElementById(divId).style.display="block";
	 	setTimeout("hideReturnedMessage('"+divId+"')",4000);
	 } 
function hideReturnedMessage(divId){
	 	document.getElementById(divId).style.display="none";
	 } 
	 
function echeck(str) {

			var at="@"
			var dot="."
			var lat=str.indexOf(at)
			var lstr=str.length
			var ldot=str.indexOf(dot)
			if (str.indexOf(at)==-1){
			
			   return false
			}
			
			if (str.indexOf(at)==-1 || str.indexOf(at)==0 || str.indexOf(at)==lstr){
			   
			   return false
			}
			
			if (str.indexOf(dot)==-1 || str.indexOf(dot)==0 || str.indexOf(dot)==lstr){
			    
			    return false
			}
			
			if (str.indexOf(at,(lat+1))!=-1){
			   
			    return false
			}
			
			if (str.substring(lat-1,lat)==dot || str.substring(lat+1,lat+2)==dot){
			
			    return false
			}
			
			if (str.indexOf(dot,(lat+2))==-1){
			  
			    return false
			}
			
			if (str.indexOf(" ")!=-1){
			
			    return false
			}
			
			return true 
	}
function showDivError(divId){
	 	document.getElementById(divId).style.display="block";
	 	setTimeout("hideReturnedMessage('"+divId+"')",4000);
	 } 
function hideDivError(divId){
	 	document.getElementById(divId).style.display="none";
	 } 