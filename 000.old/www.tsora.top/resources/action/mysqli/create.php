<?php
/**
* @name 创建操作
* 
* 
* 
* 
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

function create_tb($link,$tbname,$struct){
	$sql=sprintf("CREATE TABLE `%s`(%s)",$tbname,$struct);
	// echo $sql;
	$result=mysqli_query($link,$sql);
	// 判断是否执行
	if(!$result){
		return false;
	}

	return true;
}



/**
* 新建数据库
*
*
*/
function create_db($link,$dbname){
	$sql=sprintf("CREATE DATABASE %s",$dbname);
	$result=mysqli_query($link,$sql);
	// 判断是否执行
	if(!$result){
		// return false;
		die("数据库创建失败！".$sql);
	}

	return true;
}