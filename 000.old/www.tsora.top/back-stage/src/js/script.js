function getPath(baseUrl){
	var path=""
	for(var i=0;i<=window.location.href.substring(window.location.href.indexOf(baseUrl)+baseUrl.length).split('/').length-2;i++){
		path+="../";
	}
	return  path;
}
function getFloders(url){
	var flodersList=[];
	$.ajaxSettings.async = false;
	$.post(path+'action/floder/select.php',{"url":url},function(data1){
		// console.log(data1);
		for(var i in data1){
			// console.log(data1[i].dirname);
			data1[i].flodersList=getFloders(url+'/'+data1[i].dirname+'/');
			data1[i].filesList=getFiles(url+'/'+data1[i].dirname+'/');
		}
		// console.log(data1);
		flodersList=data1;
	},"json");
	// console.log(flodersList);
	return flodersList;
	$.ajaxSettings.async = true;
}
function getFiles(url){
	var filesList=[];
	$.ajaxSettings.async = false;
	$.post(path+'action/file/select.php',{"url":url},function(data2){
		// console.log(data2);
		filesList=data2;
	},"json");
	return filesList;
	$.ajaxSettings.async = true;
}