<?php
/**
* @name 抓取zol网站数据
*
* @description 提取网站数据
* @author tsora
* @update 2018-10-24
* @vendor PHP\Apache\MySQL
* @todo 时间获取错误
* 
* 
* 
* 
* 
*/
 $html = file_get_contents("http://top.zol.com.cn/");


$html = mb_convert_encoding($html, "utf8","GBK");
$html = preg_replace('/\r|\n|  |	/', '', $html);

echo "<textarea style='width:1000px;height:500px;'>" . $html . "</textarea>";

preg_match_all('/<div class="wrapper">(.*?)<\/div><script/i',$html,$step1_main);

var_dump($step1_main);
preg_match_all('/<div class="rank-module__head(.*?)<\/div>/i',$step1_main[0][0],$step2_div);
var_dump($step2_div);
