<?php

/**
* @name extract_file_content() 提取文件内容
* 
* @description 根据url地址，获取文件内容，并根据arr中操作步骤输出数据
* @access public
* @param string $url 文件地址
* @param array $action 操作步骤
* @return string
* @todo 开发未完成 暂使用extract_page_content
*
*/
function extract_file_content($url,$action){
	if(!is_string($url)){
		die("url参数格式错误");
	}else if(!is_array($action)){
		die("step参数格式错误");
	}else{
		$file=file_get_contents($url);
		$arr=array();
		echo "<textarea style='height:600px;width:800px;'>".$file."</textarea>";
		foreach($action as $k=>$v){
			var_dump($v);
			var_dump($v["type"]);
			switch($v["type"]){
				case "pcre":
				echo 123;
				break;
				default:
				echo "default";
				break;
			}
		} 
	}
}