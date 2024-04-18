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
		return true;
	}else{
		return false;
	}
}