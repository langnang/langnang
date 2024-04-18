<?php
/**
* @name 显示是否存在
* 
* @description 显示是否存在
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
* @name 显示所有数据库
* @param String tbname
* @return 
* 
*/
function show_dbnames($link){
	$sql=sprintf("show databases");
	// echo $sql;
	$result=mysqli_query($link,$sql);
	// 判断查询是否
	// var_dump($result);
	if(!$result){
		return false;
	}
	$array=array();
	while($row=mysqli_fetch_array($result)){
		array_push($array,$row["Database"]);
	}
	return $array;
}

/**
* @name 判断数据库是否存在
*/

function if_exists_db($link,$dbname){
	$sql=sprintf("show databases like '%s'",$dbname);
	// $sql=sprintf("select * from `vendor`");
	echo $sql;
	$result=mysqli_query($link,$sql);
	// 判断查询是否
	// var_dump($result);
	if(!$result){
		return false;
	}

	if($result->num_rows!==1){
		return false;
		// die(false);
	}

	return true;
}

/**
* @name 判断表是否存在
* @param String tbname
* @return 
* 
*/
function if_exists_tb($link,$tbname){
	// var_dump($link);
	$sql=sprintf("show tables like '%s'",$tbname);
	// $sql=sprintf("select * from `vendor`");
	// echo $sql;
	$result=mysqli_query($link,$sql);
	// 判断查询是否
	// var_dump($result);
	if(!$result){
		return false;
	}

	if($result->num_rows!==1){
		return false;
		// die(false);
	}

	return true;
}