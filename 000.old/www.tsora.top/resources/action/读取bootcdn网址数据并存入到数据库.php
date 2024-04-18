<?php
/**
* 
* 
* 
* 
* 
* 
* 
* 
*/

// 引入所有文件
include 'index.php';

// 设置数据库响应时间无限制
set_time_limit(0);


// 链接数据库
$link=connect_mysql_db("localhost","root","","tsora",3306);
echo "<br>";
// var_dump($link);

// 查询表中所有数据量
// $count=select_count_all_table($link,"vendor_bootcdn");
// var_dump($count);


// 查询数据
$select=select_mysql($link,"select `name` FROM `vendor_bootcdn` WHERE `content`='[]'");
var_dump($select);
while($msg=mysqli_fetch_array($select)){
	foreach(array_unique($msg) as $key=>$value){
		// var_dump($value);
		$json=extract_bootcdn_content_rule1("https://www.bootcdn.cn/" . $value . "/");
		// var_dump($json);
		$sql="update `vendor_bootcdn` set `content` = '". json_encode($json) ."' where `name` = '" . $value . "'";
		// echo $sql;
		insert_mysql($link,$sql);
	}
}

// $url="https://www.bootcdn.cn/";
// $arr=array();
// array_push($arr,array("type"=>'pcre',"reg"=>'2'));
// extract_file_content($url,$arr);


// insert_mysql($link,"INSERT INTO `tsora`.`vendor-bootcdn`(`id` ,`name`, `description`, `heat`, `package`) VALUES ( '1','', '', '', '121')");

// empty_mysql_table($link,"vendor_bootcdn");

// extract_file_content("https://www.bootcdn.cn/all/",array());

// extract_bootcdn_all_content($link,"vendor_bootcdn");
// var_dump($bootcdn);
// foreach($bootcdn as $key=>$value){
	// var_dump($value);
	// echo $key;
	// $sql="INSERT INTO `vendor_bootcdn`(`id`, `name`, `description`, `heat`, `package`) VALUES (".$value["ID"].", '".$value["name"]."', '".$value["description"]."', '".$value["heat"]."', '".json_encode($value["package"])."')";
	// echo $sql;
	// insert_mysql($link,$sql);
// }

// $count=select_count_all_table($link,"vendor_bootcdn");
// echo $count;
	// $sql="select id from `vendor_bootcdn` where content = '[]'" ;
	// echo $sql;
	// var_dump(select_mysql($link,$sql));
	// var_dump(select_mysql($link,$sql)->num_rows);
	// var_dump(mysqli_fetch_array(select_mysql($link,$sql))["id"]);
	// while($msg = mysqli_fetch_array(select_mysql($link,$sql))){
		// echo $msg["id"];
	// }
	// extract_bootcdn_package_content("https://www.bootcdn.cn/".select_mysql($link,$sql)->fetch_array()[0]."/");
	// $bootcdn_package=extract_bootcdn_package_content("https://www.bootcdn.cn/".select_mysql($link,$sql)->fetch_array()[0]."/");
	// $sql="update `vendor_bootcdn` set `package` = '". json_encode($bootcdn_package) ."' where `id` = ". $i;
	// echo $sql;
	// insert_mysql($link,$sql);
