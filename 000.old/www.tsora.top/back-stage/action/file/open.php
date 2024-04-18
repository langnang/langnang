<?php


/*
 * @name openFolder 打开文件夹
 * @param url 访问地址
 *
 *
 *
 *
*/

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

	return "[".$str."]";
}

