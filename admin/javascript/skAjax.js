YAHOO.namespace("example.container");
var oResponse;
function showLoader(){
	        if (!YAHOO.example.container.wait) {
	
	            // Initialize the temporary Panel to display while waiting for external content to load
	
	            YAHOO.example.container.wait = 
	                    new YAHOO.widget.Panel("wait",  
	                                                    { width: "600px", 
	                                                   	  height: "20px",
	                                                      fixedcenter: false, 
	                                                      close: false, 
	                                                      draggable: false, 
	                                                      zindex:4,
	                                                      modal: true,
	                                                      visible: false
	                                                    } 
	                                                );
	    
	            YAHOO.example.container.wait.setHeader("");
	            /*YAHOO.example.container.wait.setBody("<div align='center'><img style=\"margin-right: 0px;\" align=\"center\" src=\"images/ajax-loader.gif\"/></div>");*/
	            YAHOO.example.container.wait.setBody('<div align="right"  style="margin-left: 980px;margin-top:185px;padding-bottom: 150px;"><img   src="images/spacer.gif"/></div>');
	            YAHOO.example.container.wait.render(document.body);
	     	   // Show the Panel
		}
YAHOO.example.container.wait.show();
}
function hideLoader(callbackFunction){
	if(callbackFunction != null){
	 	 //callback a function 
 		 var t=setTimeout(callbackFunction+"()",0);
	}

 YAHOO.example.container.wait.hide();
 return oResponse;
}

function sendAjaxRequest(url, ajaxResponse, callbackFunction_success, callbackFunction_failure){
showLoader();
 var callback = {
            success : function(o) {
                ajaxResponse.innerHTML = o.responseText;
                oResponse = o.responseText;
                ajaxResponse.style.visibility = "visible";
                hideLoader(callbackFunction_success);
            },
            failure : function(o) {
                ajaxResponse.innerHTML = o.responseText;
                oResponse = o.responseText;
                ajaxResponse.style.visibility = "visible";
                ajaxResponse.innerHTML = "CONNECTION FAILED!";
                hideLoader(callbackFunction_failure);
            }
          }
//ajaxResponse.innerHTML = "";
// Connect to our data source and load the data
var conn = YAHOO.util.Connect.asyncRequest("GET", url, callback);
}

function getURL(link, object){
	var objectString = "";
	if(object != undefined && object != null)
	{
		for(var objectField in object)
		{
			if(objectString != "")
			{
				objectString += "&";
			}
			if(object[objectField] instanceof Array == false)
			{
				objectString += encodeURIComponent(objectField) + "=" + encodeURIComponent(object[objectField]);
			}
			else
			{
				for(var i = 0; i < object[objectField].length; i++)
				{
					objectString += encodeURIComponent(objectField) + "=" + encodeURIComponent(object[objectField][i]);
					if(i  < object[objectField].length - 1)
					{
						objectString += "&";
					}
				}
			}
		}
	}
	return link+"?"+objectString;

}

function addAjaxEvent(objectId, eventType, handler){
return YAHOO.util.Event.on(objectId, eventType, handler);
}   
