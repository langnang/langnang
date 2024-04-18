<?php


/*
 * @name openAllFiles 获取所有文件 
 *
 * @para url 文件位置
 *
 *
*/


include_once("../file/open.php");

$url=isset($_POST["url"])?$_SERVER['DOCUMENT_ROOT'].$_POST["url"]:$_SERVER['DOCUMENT_ROOT']."/";
echo openFolder($url);
