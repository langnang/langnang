<?php

/**
* 
* 
* 
* 
* 
* 
* 
* 
* 
*/

// 更新文件内容
function writeFile($url,$content){
	$result=file_put_contents($url, $content);
	if($result){
		echo "更新成功";
	}else{
		echo "更新失败";
	}
}