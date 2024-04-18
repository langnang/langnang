<?php 


/**
*
*/ 



// 获取文件内容
function readFileContent($url){
	return file_get_contents($url);
}

// 读取网站内容
function readWebSite($url){
	header("Content-type: text/html; charset=utf-8");
	return file_get_contents($url);
}