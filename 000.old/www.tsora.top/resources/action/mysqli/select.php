<?php


/**
* @name select_count_all_table 查询表中数据量
*
*
*
*/
function count_all_table($link,$table){
	$sql="select count(*) from ".$table;
	$result=mysqli_query($link,$sql);
	if(!$result){
		die ("计算数据量失败=>".$sql);
	}
	return $result->fetch_array()[0];

}


/**
* @name 查询数据库数据
* 
* @description 数据库查询方法汇总
* @author tsora
* @version 0.0.1
* @update 2018-09-25
* @todo ...
* @vendor MySQL-5.0.12 PHP-7.2.6 Apache-2.4.33
* 
*/


/**
* @name 获取mysql某个数据库中所有表名
* 
* @description
* @param Object link
* @param String dbname
* @return Array
* 
*/
function select_all_tbname($link,$dbname){

}

/**
* @name 获取mysql某个表中所有列名
* 
* @description
* @param Object link
* @param String tbname
* @return Array
* 
*/
function select_all_colname($link,$tbname){
	$sql=sprintf("select COLUMN_NAME from information_schema.COLUMNS where table_name = '%s'",$tbname);
	$result=mysqli_query($link,$sql);
	if(!$result){
		return "数据查询失败";
	}else{
		// var_dump($result);
		$data=array();
		while($row=mysqli_fetch_array($result)){
			// var_dump($row["COLUMN_NAME"]);
			array_push($data,$row["COLUMN_NAME"]);
		}
		return $data;
	}
}


/**
* @name 获取表中所有数据量
* 
* @description 获取表中所有数据量
* @param Object link
* @param String tbname
* @return Int
* 
*/
function count_all_data($link,$tbname){
	$sql=sprintf("select count(*) from `%s`",$tbname);
	// echo $sql;
	$result=mysqli_query($link,$sql);
	if(!$result){
		return "数据查询失败";
	}else{
		// var_dump($result);
		$data=array();
		while($row=mysqli_fetch_array($result)){
			return $row[0];
			// var_dump($row[0]);
			// array_push($data,$row[0]);
		}
		// return $data;
	}
}

/**
* @name 获取表中指定数量的数据
* 
* @description 获取表中指定数量的数据
* @param Object link
* @param String tbname
* @param Int row
* @return Array
* 
*/
function select_limit_data($link,$tbname,$row,$limit){
	$sql=sprintf("select * from `%s` limit %s,%s",$tbname,$row,$limit);
	// echo $sql;
	$result=mysqli_query($link,$sql);
	if(!$result){
		return "数据查询失败";
	}else{
		// var_dump($result);
		$data=array();
		while($row=mysqli_fetch_array($result)){
			// var_dump($row);
			array_push($data,$row);
		}
		return $data;
	}
}

/**
* @name 获取表中所有数据
* 
* @description 获取表中所有数据
* @param Object link
* @param String tbname
* @return Array
* 
*/
function select_all_data($link,$tbname){
	$sql=sprintf("select * from `%s`",$tbname);
	$result=mysqli_query($link,$sql);
	if(!$result){
		return "数据查询失败";
	}else{
		// var_dump($result);
		$data=array();
		while($row=mysqli_fetch_array($result)){
			// var_dump($row["COLUMN_NAME"]);
			array_push($data,$row["COLUMN_NAME"]);
		}
		return $data;
	}
}

/**
* @name 获取表中所有查询数据
* 
* @description 获取表中所有查询数据
* @param Object link
* @param String tbname
* @return Array
* 
*/
