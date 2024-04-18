<?php
/**
* @name 抓取bootcdn网站数据
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
require_once($_SERVER["DOCUMENT_ROOT"]."/resources/action/api/Models/BootCDNModel.php");
/**
 * 
 */
class BootCDN extends MySQLiController
{
    static $tbname="bootcdn";
    
    function __construct($argument)
    {
        return info(__FUNCTION__);
    }
    function index(){
        return success(self::$tbname);
    }
    function mysqli_select_all_like($data){
        
    }
}
/*
include_once($_SERVER['DOCUMENT_ROOT']."/resource/action/api/grab-data/default.php");
// var_dump($mysql->tbname);
$mysql->tbname="bootcdn";
// var_dump($mysql->tbname);
// 判断表是否存在
if(!if_exists_tb($link,$mysql->tbname)){
    // 表不存在
    // echo $mysql->tbname."不存在";
    $sql="CREATE TABLE `".$mysql->tbname."`  (
    `id` int(11) NOT NULL,
    `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
    `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
    `heat` int(11) NULL DEFAULT NULL,
    `content` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
    `time` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0),
    PRIMARY KEY (`id`) USING BTREE) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;";
    // var_dump($sql);
    // 创建数据库
    if(!mysql_default($link,$sql)){
        echo "数据库创建失败";
    }
    // 关闭外键约束
    $sql="SET FOREIGN_KEY_CHECKS = 0;";
    mysql_default($link,$sql);
};
empty_table($link,$mysql->tbname);

// 设置数据库响应时间无限制
set_time_limit(0);

grab_bootcdn_all_data($link,$mysql->tbname);
*/

/**
* @name 读取bootcdn网址all页面内容
*
* @description 基于PHP的filesystem扩展，获取bootcdn网址页面内容并抓取
* @author tsora <1624327728@qq.com>
* @version 0.0.1
* @update 2018-09-20
* @vendor PHP-7.2.6 Apache-2.4.33
* @todo ...
* 
* 
*/
/*
function grab_bootcdn_all_data($link,$tbname){
    // 读取页面全部内容
    $html = file_get_contents("https://www.bootcdn.cn/all/");
    // echo "<textarea style='width:1000px;height:300px;'>" . $html . "</textarea>";

    // 匹配正则表达式
    preg_match_all('/<main class=packages-list-container id=all-packages>(.*)<\/main>/i',$html,$step1_main);
    // var_dump($step1_main);
    // echo "<textarea style='width:1000px;height:300px;'>" . $step1_main[0][0] . "</textarea>";


    // 匹配正则表达式
    preg_match_all('/<a href=\/(.*?)\/ class="package list-group-item" target=_blank onclick="(.*?)"><div class=row><div class=col-md-3><h4 class=package-name>(.*?)<\/h4><\/div><div class="col-md-9 hidden-xs"><p class=package-description>(.*?)<\/p><\/div><div class="package-extra-info col-md-9 col-md-offset-3 col-xs-12"><span><i class="fa fa-star"><\/i>(.*?)<\/span><\/div><\/div><\/a>/i',$step1_main[0][0],$step2_a);
    # preg_match_all('/<a href=\/(.*?)\/ class="package list-group-item" target=_blank onclick="(.*?)"><div class=row><div class=col-md-3><h4 class=package-name>(.*?)<\/h4><\/div><div class="col-md-9 hidden-xs"><p class=package-description>(.*?)<\/p><\/div><div class="package-extra-info col-md-9 col-md-offset-3 col-xs-12"><span><i class="fa fa-star"><\/i> (.*?)<\/span><\/div><\/div><\/a>/i',$step1_main[0][0],$step2_a);
    // var_dump($step2_a);
    // $bootCND=array();
    // 遍历匹配结果，将结果转化为json数组
    for($i=0;$i < count($step2_a[0]);$i++){
    // for($i=count($step2_a[0])-5;$i < count($step2_a[0]);$i++){
    // for($i=0;$i < 5;$i++){

        $arr_json=array('ID'=>$i+1,'name'=>$step2_a[1][$i],'description'=>$step2_a[4][$i],'heat'=>(int)$step2_a[5][$i],'content'=>grab_bootcdn_content("https://www.bootcdn.cn/".$step2_a[1][$i]."/"));
        // var_dump($arr_json);

    //     // array_push($bootCND,$arr_json);
        $sql="INSERT INTO `".$tbname."`(`id`, `name`, `description`, `heat`,`content`, `time`) VALUES (" . $arr_json["ID"]. ",'" . $arr_json["name"] . "','" . $arr_json["description"] . "'," . $arr_json["heat"] . ",'" . json_encode($arr_json["content"]) ."','" . date("Y-m-d h:i:sa") . "')";
        // echo $sql;
        mysql_default($link,$sql);

        if($i==count($step2_a[0])){
            echo $i;
        }

    }
    // var_dump($bootCND);
    // return $bootCND;

}*/
// grab_bootcdn_all_data();

/**
* @name extract_bootcdn_package_content 提取BootCDN/次级页面内容
*
*/
/*
function grab_bootcdn_content($url){
    // 读取页面内容
    $html=file_get_contents($url);
    // 匹配正则表达式
    preg_match_all('/<main class=container>(.*)<\/main>/i',$html,$step1_main);
    // 匹配正则表达式
    preg_match_all('/<a class=version-anchor id=(.*?)><\/a><h3>(.*?)<\/h3><div class=package-version>(.*?)<\/div>/i',$step1_main[0][0],$step2_a);
    $bootCDN_list=array();
    // 判断结果数量
    if(count($step2_a[0])>1){
    // 遍历匹配结果，将结果转化为json数组
        for($i=0;$i < count($step2_a[0])-1;$i++){
            // 匹配正则表达式
            preg_match_all('/<li class="list-group-item library js-https"><span class=library-url>(.*?)<\/span><\/li>/i',$step2_a[3][$i],$step3_li);

            $arr_json=array('version'=>$step2_a[1][$i],'package'=>$step3_li[1]);
            array_push($bootCDN_list,$arr_json);

        }
    }else if(count($step2_a[0])==1){
        preg_match_all('/<li class="list-group-item library js-https"><span class=library-url>(.*?)<\/span><\/li>/i',$step2_a[3][0],$step3_li);

        $arr_json=array('version'=>$step2_a[1][0],'package'=>$step3_li[1]);
        array_push($bootCDN_list,$arr_json);

    }
    
    return $bootCDN_list;
}
*/