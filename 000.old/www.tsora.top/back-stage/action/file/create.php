<?php



/*
 * @name 新建文件夹
 *
 * @param string url 文件目录
 *
*/



function createFolder($url){
	if(!is_dir($url)){
		mkdir($url);
		return true;
	}else{
		return false;
	}

}

function createFile($url){
	if(!file_exists($url)){
		fopen($url,"wb");
		return true;
	}else{
		return false;
	}
}