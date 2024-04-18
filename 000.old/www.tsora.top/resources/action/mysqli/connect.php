<?php

/**
* mysql_connect.php 连接MySQL数据库
* 
* 基于MySQL-5.0.12,PHP-7.2.6,Apache-2.4.33的环境连接MySQL操作
* @author tsora <...>
* @version 0.0.1 2018-09-20
* @since 0.0.0
* @todo ...
*
*/

function connect_mysql($host,$username,$password){
	$link = mysqli_connect($host, $username, $password);
	if (!$link){
		return false;
	}
	// echo "<br>数据库连接成功<br>";
	return $link;
}

// 链接数据库
function connect_db($link,$dbname){
	$link = mysqli_connect($link,$dbname);
	if (!$link){
		die("连接失败"); 
	}
	// echo "<br>数据库连接成功<br>";
	return $link;
}
