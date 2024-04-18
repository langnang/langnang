<?php

/*
 * 
 * Name:file_select
 * Descripe:获取指定目录下文件信息(类型/大小/创建时间/修改时间/访问时间)
 * Author:TSORA
 * Version:0.0.1
 * Update:2018-09-07
 *
*/

$url=$_POST["url"];

include_once '../url/level.php';

$handler = opendir($route.$url);
$str='';
$file='';
while( ($filename = readdir($handler)) !== false ) {
	// echo $filename;
	if($filename != "." && $filename != ".." && filetype($route.$url.$filename)=="file"){
		// echo filetype($route.$url.$filename);//文件类型,dir/file
		// echo filesize($route.$url.$filename);//获得文件的大小,返回字节
		// echo date('Y-m-d H:i:s',filectime($route.$url.$filename));//获取文件的创建时间
		// echo '文件创建时间为：'.date('Y年m月d日 H:i:s',filectime($filename)).'<br/>';
		//filemtime($filename):文件的修改时间
		// echo '文件的修改时间为：'.date("Y/m/d H:i:s",filemtime($filename)).'<br/>';
//fileatime($filename):文件的最后访问时间
		// echo '文件的最后访问时间为：'.date("Y/m/d H:i:s",fileatime($filename)).'<br/>';
		// echo $filename;
		// if(is_dir($route.$url.$filename)){//判断相对路径下是否文件夹
			// echo $filename;
		if($str===""){
			$str='{"filename":"'.$filename.'","type":"file","createtime":"'.date('Y-m-d H:i:s',filectime($route.$url.$filename)).'","updatetime":"'.date('Y-m-d H:i:s',filemtime($route.$url.$filename)).'","visittime":"'.date('Y-m-d H:i:s',fileatime($route.$url.$filename)).'"}';
		}else{
			$str=$str.',{"filename":"'.$filename.'","type":"file","createtime":"'.date('Y-m-d H:i:s',filectime($route.$url.$filename)).'","updatetime":"'.date('Y-m-d H:i:s',filemtime($route.$url.$filename)).'","visittime":"'.date('Y-m-d H:i:s',fileatime($route.$url.$filename)).'"}';
		}
		// }else{
			// echo "这不是一个目录";
		// }

// 		// if(strpos($filename, '.json')!==false||strpos($filename, '.js')!==false||strpos($filename, '.html')!==false||strpos($filename, '.txt')!==false||strpos($filename, '.php')!==false||strpos($filename, '.css')!==false){
// 		// }else{
// 		// 	if($str===""){
// 		// 		$str='{"ID":"'.$filename.'","name":"","description":""}';
// 		// 	}else{
// 		// 		$str=$str.',{"ID":"'.$filename.'","name":"","description":""}';
// 		// 	}
// 		// }
	}
}
closedir($handler);

echo "[".$str."]";