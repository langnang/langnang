<?php


/*
 * @name 更新文件内容
 *
 * @param string url
 * @param string content
 *
 *
 *
 */


$url=$_POST["url"];

$content=$_POST["content"];


include_once("../file/write.php");

echo writeFile($_SERVER['DOCUMENT_ROOT'].$url,$content);