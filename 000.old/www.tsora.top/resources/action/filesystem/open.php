<?php
/**
* 
* 
*/

// 获取文件夹中文件属性
function openFolder($url){
	$handler = opendir($url);
	$str='';
	$file='';
	while( ($filename = readdir($handler)) !== false ) {

		if($filename != "." && $filename != ".."){

			if($str===""){
				$str='{
					"filename":"'.$filename.'",
					"filetype":"'.filetype($url.$filename).'",
					"filesize":"'.filesize($url.$filename).'",
					"createtime":"'.date('Y-m-d H:i:s',filectime($url.$filename)).'",
					"updatetime":"'.date('Y-m-d H:i:s',filemtime($url.$filename)).'",
					"visittime":"'.date('Y-m-d H:i:s',fileatime($url.$filename)).'"
				}';
			}else{
				$str=$str.',{
					"filename":"'.$filename.'",
					"filetype":"'.filetype($url.$filename).'",
					"filesize":"'.filesize($url.$filename).'",
					"createtime":"'.date('Y-m-d H:i:s',filectime($url.$filename)).'",
					"updatetime":"'.date('Y-m-d H:i:s',filemtime($url.$filename)).'",
					"visittime":"'.date('Y-m-d H:i:s',fileatime($url.$filename)).'"
				}';
			}
		}
	}
	closedir($handler);

	echo "[".$str."]";
}

function openFile($url){
	$str='{
		"filename":"'.$url.'",
		"filetype":"'.strtolower(substr($url,strrpos($url,".")+1)).'",
		"filesize":"'.filesize($_SERVER['DOCUMENT_ROOT'].$url).'",
		"createtime":"'.date('Y-m-d H:i:s',filectime($_SERVER['DOCUMENT_ROOT'].$url)).'",
		"updatetime":"'.date('Y-m-d H:i:s',filemtime($_SERVER['DOCUMENT_ROOT'].$url)).'",
		"visittime":"'.date('Y-m-d H:i:s',fileatime($_SERVER['DOCUMENT_ROOT'].$url)).'"
	}';
	echo "[".$str."]";
}



// 获取文件夹及其子文件夹中文件属性
function openSubFolder($url){
	openFolder($url);
}