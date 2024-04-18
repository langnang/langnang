<?php
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



/**
* @name extract_bootcdn_all_content 读取BootCDN/all页面内容
* 
* 
* 
* 
* 
* 
*/
// function extract_bootcdn_all_content(){
// 	// 读取页面全部内容
//     $html = file_get_contents("https://www.bootcdn.cn/all/");
//     // 匹配正则表达式
//     preg_match_all('/<main class=packages-list-container id=all-packages>(.*)<\/main>/i',$html,$step1_main);
//     // 匹配正则表达式
//     preg_match_all('/<a href=\/(.*?)\/ class="package list-group-item" target=_blank onclick="(.*?)"><div class=row><div class=col-md-3><h4 class=package-name>(.*?)<\/h4><\/div><div class="col-md-9 hidden-xs"><p class=package-description>(.*?)<\/p><\/div><div class="package-extra-info col-md-9 col-md-offset-3 col-xs-12"><span><i class="fa fa-star"><\/i> (.*?)<\/span><\/div><\/div><\/a>/i',$step1_main[0][0],$step2_a);
//     $bootCND=array();
//     // 遍历匹配结果，将结果转化为json数组
//     for($i=0;$i < count($step2_a[0])-1;$i++){

//     	$arr_json=array('ID'=>$i+1,'name'=>$step2_a[1][$i],'description'=>$step2_a[4][$i],'heat'=>(int)$step2_a[5][$i],'content'=>'');
//       array_push($bootCND,$arr_json);
//     	// $sql="INSERT INTO `vendor_bootcdn`(`id`, `name`, `description`, `heat`, `package`,`time`) VALUES (" . $arr_json["ID"]. ",'" . $arr_json["name"] . "','" . $arr_json["description"] . "'," . $arr_json["heat"] . ",'" . $arr_json["package"] . "','" . date("Y-m-d H:i:s") . "')";
//     	// insert_mysql($link,$sql);

//   }
//   return $bootCND;

// }

/**
* @name extract_bootcdn_all_content 读取BootCDN/all页面内容
* 
* 
* 
* 
* 
* 
*/
function extract_bootcdn_all_content($link,$table){
    // 读取页面全部内容
    $html = file_get_contents("https://www.bootcdn.cn/all/");
    // 匹配正则表达式
    preg_match_all('/<main class=packages-list-container id=all-packages>(.*)<\/main>/i',$html,$step1_main);
    echo "<textarea style='width:1200px;height:300px;'>" . $html . "</textarea>";
    
    // 匹配正则表达式
    preg_match_all('/<a href=\/(.*?)\/ class="package list-group-item" target=_blank onclick="(.*?)"><div class=row><div class=col-md-3><h4 class=package-name>(.*?)<\/h4><\/div><div class="col-md-9 hidden-xs"><p class=package-description>(.*?)<\/p><\/div><div class="package-extra-info col-md-9 col-md-offset-3 col-xs-12"><span><i class="fa fa-star"><\/i> (.*?)<\/span><\/div><\/div><\/a>/i',$step1_main[0][0],$step2_a);
    $bootCND=array();
    // 遍历匹配结果，将结果转化为json数组
    for($i=0;$i < count($step2_a[0])-1;$i++){

        $arr_json=array('ID'=>$i+1,'name'=>$step2_a[1][$i],'description'=>$step2_a[4][$i],'heat'=>(int)$step2_a[5][$i],'content'=>'');
        array_push($bootCND,$arr_json);
        // $sql="INSERT INTO `vendor_bootcdn`(`id`, `name`, `description`, `heat`, `package`,`time`) VALUES (" . $arr_json["ID"]. ",'" . $arr_json["name"] . "','" . $arr_json["description"] . "'," . $arr_json["heat"] . ",'" . $arr_json["package"] . "','" . date("Y-m-d H:i:s") . "')";
        // insert_mysql($link,$sql);

    }
    return $bootCND;

}



/**
* @name 读取bootcdn网址详细页面内容
*
* @description 基于PHP的filesystem扩展，获取bootcdn网址详细页面内容并抓取，由于该网址详细页面内容排序并不相同，因此需设计安排多个提取规则rule
* @author tsora <1624327728@qq.com>
* @version 0.0.1
* @update 2018-09-20
* @vendor PHP-7.2.6 Apache-2.4.33
* @todo ...
* 
* 
*/



/**
* @name extract_bootcdn_package_content 提取BootCDN/次级页面内容
*
*/
function extract_bootcdn_content_rule1($url){
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
/**
* @name extract_bootcdn_package_content 提取BootCDN/次级页面内容
*
*/
function extract_bootcdn_content_rule_test($url){
    var_dump($url);
    // 读取页面内容
    $html=file_get_contents($url);
    // echo "<textarea style='width:1200px;height:300px;'>" . $html . "</textarea>";
    // 匹配正则表达式
    preg_match_all('/<main class=container>(.*)<\/main>/i',$html,$step1_main);
    var_dump($step1_main);
    // 匹配正则表达式
    preg_match_all('/<a class=version-anchor id=(.*?)><\/a><h3>(.*?)<\/h3><div class=package-version>(.*?)<\/div>/i',$step1_main[0][0],$step2_a);
    // echo "<textarea style='width:1200px;height:300px;'>" . $step1_main[0][0] . "</textarea>";

    var_dump($step2_a);
    $bootCDN_list=array();
    echo count($step2_a[0]);
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
        // 判断bootcdn_list的值
        echo count($bootCDN_list);

    }
    var_dump($bootCDN_list);
    return $bootCDN_list;
}