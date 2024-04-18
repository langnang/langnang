<?php

/**
* 
* 
* 
* 
*/


function createFile($url){
	if(!file_exists($url)){
		if(fopen($url,"wb")){
			echo "文件创建成功";
		}else{
			echo "文件创建失败";
		}
	}else{
		echo "文件已存在";
	}
}


function createFolder($url){
	if(!is_dir($url)){
		mkdir($url);
		return true;
	}else{
		return false;
	}

}