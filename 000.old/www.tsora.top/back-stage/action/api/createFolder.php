<?php


/*
 * @name 新建文件夹
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

echo createFolder($_SERVER['DOCUMENT_ROOT'].$url);


