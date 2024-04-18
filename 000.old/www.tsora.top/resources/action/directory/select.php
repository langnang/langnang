<?php

$url=$_POST["url"];
// echo $url;
// echo 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
$baseUrl="action";
include_once '../url/level.php';
// echo $route;


$handler = opendir($route.$url);
$str='';
$file='';
while( ($filename = readdir($handler)) !== false ) {

	if($filename != "." && $filename != ".." && filetype($route.$url.$filename)=="dir"){
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
			$str='{"dirname":"'.$filename.'","type":"dir","createtime":"'.date('Y-m-d H:i:s',filectime($route.$url.$filename)).'","updatetime":"'.date('Y-m-d H:i:s',filemtime($route.$url.$filename)).'","visittime":"'.date('Y-m-d H:i:s',fileatime($route.$url.$filename)).'"}';
		}else{
			$str=$str.',{"dirname":"'.$filename.'","type":"dir","createtime":"'.date('Y-m-d H:i:s',filectime($route.$url.$filename)).'","updatetime":"'.date('Y-m-d H:i:s',filemtime($route.$url.$filename)).'","visittime":"'.date('Y-m-d H:i:s',fileatime($route.$url.$filename)).'"}';
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