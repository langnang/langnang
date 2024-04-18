<?php


/**
* @name insert_mysql 插入数据到数据表
* 
* @description 根据url地址，获取文件内容，并根据arr中操作步骤输出数据
* @access public
* @param string $host 服务器
* @param string $username 用户名
* @param string $password 密码
* @param string $dbname 数据库
* @param string $port 服务器端口号
* @return object 返回表示与MySQL服务器的连接的对象
*
*
*/
function insert_mysql($link,$sql){
	$result=mysqli_query($link,$sql);
	if(!$result){
		die ("数据插入失败");
	}
}




/**
* @name 插入数据到数据库
* @param Object
* 
* 
*/
function insert_table($link,$tbname,$struct){
	$sql=sprintf("insert into `%s` %s",$tbname,$struct);
	$result=mysqli_query($link,$sql);
	// 判断是否执行
	if(!$result){
		return false;
	}

	return true;
}