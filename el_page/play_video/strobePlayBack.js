 
function displayPage(){
	var param = document.getElementsByTagName("param");
	for(var i = 0; i < param.length; i++){
		param[i].value = "";
	}
}


//another stop load time
//若載入影片失效時，可以註解上面的方法，改用這個方法。
/* jQuery(document).ready(function(){
	var param = document.getElementsByTagName("param");	
	alert("Video is ready!");
	for(var i = 0; i < param.length; i++){
		param[i].value = "";
	}
}) */