<?php
/*
 * Name:mysql_close
 * Description:关闭MySQL数据库连接
 * Author:TSORA
 * Version:0.0.1
 * Update:2018-09-14
 * Vendor:MySQL-5.0.12,PHP-7.2.6,Apache-2.4.33
 *
 *
*/


// 连接数据库
include 'connect.php';

// 关闭连接
// mysqli_close($conn);

// 检测数据库连接是否关闭
if(mysqli_close($conn)){
	die("连接关闭失败");
}


?>