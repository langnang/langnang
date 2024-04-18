<?php


/*
 * @name 新建文件
 *
 *
 * @param string url
 *
 *
 *
 *
 *
*/


$url=$_POST["url"];
include_once("../file/create.php");

echo createFile($_SERVER['DOCUMENT_ROOT'].$url);


