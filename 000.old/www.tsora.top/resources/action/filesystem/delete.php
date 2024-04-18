<?php

/*
 * @name 删除文件
 *
 *
 *
 *
 *
 *
 */


function deleteFile($url){
	if(!unlink($url)){
		return false;
	}else{
		return true;
	}
}