<?php
/**
* @name
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

/**
* @name empty_mysql_table 清除表中数据--清空表中数据
* @param Object link
* @param String tbname
* @return Boolean
*/
function empty_table($link,$tbname){
	$sql=sprintf("truncate table `%s`",$tbname);

	$result=mysqli_query($link,$sql);
	// var_dump($result);
	// 判断是否执行
	if(!$result){
		return false;
	}

	return true;
}


/**
* @name 删除表
* @param Object link
* @param String tbname
* @return Boolean
*/
function drop_table($link,$tbname){
	$sql=sprintf("DROP TABLE IF EXISTS `%s`",$tbname);

	$result=mysqli_query($link,$sql);
	// var_dump($result);
	// 判断是否执行
	if(!$result){
		return false;
	}

	return true;
}