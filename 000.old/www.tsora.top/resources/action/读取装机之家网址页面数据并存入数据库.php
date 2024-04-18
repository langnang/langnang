<?php
/**
*
*/

// 引入文件
include 'index.php';
// 设置数据库响应时间无限制
set_time_limit(0);

// 链接数据库
$link=connect_mysql_db("localhost","root","","tsora",3306);


// 提取装机之家-电脑配置列表数据到数据库
function step1($link){
	$dnpz_page=extract_lotpc_page_num();
	// var_dump($dnpz_page);
	for($i=1;$i<=$dnpz_page["page"];$i++){
	// for($i=1;$i<=2;$i++){
		foreach(extract_lotpc_content_35($i) as $key=>$value){
			$sql='insert into `diy_pc`(`name`,`tag`,`link`,`description`,`ctime`) values ("' . $value["name"] . '","' . $value["tag"] . '","' . $value["link"] . '","' . $value["description"] . '","' . $value["ctime"] . '")';
			insert_mysql($link,$sql);
		}

	}
}
// step1($link);

// extract_lotpc_content()
// extract_lotpc_content_35(8);
// 提取详细页面内容
function step2($link){
	// $sql='select `link` from `diy_pc` limit 729,1';
	// $sql='select `link` from `diy_pc` where `id`>527';
	$sql='select `link` from `diy_pc` ';
	// $sql='select `link` from `diy_pc` limit 7,1';
	$select=select_mysql($link,$sql);
	while($msg=mysqli_fetch_array($select)){
		foreach(array_unique($msg) as $key=>$value){
		// var_dump($value);
			$url="http://www.lotpc.com".$value;
			$lotpc_price=extract_lotpc_content($url);
			// var_dump($lotpc_price);
			if($lotpc_price!==null){
				$sql='update `diy_pc` set `cpu` = "' . $lotpc_price["cpu"] . '", `cpu_price` = ' . $lotpc_price["cpu_price"] . ', `cpu_fan` = "' . $lotpc_price["cpu_fan"] . '", `cpu_fan_price` = ' . $lotpc_price["cpu_fan_price"] . ', `mb` = "' . $lotpc_price["mb"] . '", `mb_price` = ' . $lotpc_price["mb_price"] . ', `vga` = "' . $lotpc_price["vga"] . '", `vga_price` = ' . $lotpc_price["vga_price"] . ', `ram` = "' . $lotpc_price["ram"] . '", `ram_price` = ' . $lotpc_price["ram_price"] . ', `hdd` = "' . $lotpc_price["hdd"] . '", `hdd_price` = ' . $lotpc_price["hdd_price"] . ', `case` = "' . $lotpc_price["case"] . '", `case_price` = ' . $lotpc_price["case_price"] . ', `power` = "' . $lotpc_price["power"] . '", `power_price` = ' . $lotpc_price["power_price"] . ', `price_all` = ' . $lotpc_price["price_all"]  .' where `link` = "' . $value . '"';
				// echo "<textarea style='width:900px;height:300px;'>" . $sql . "</textarea>";

				insert_mysql($link,$sql);
			}else{
				var_dump($value);
			}
			
		}
	}
}
step2($link);