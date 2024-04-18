<?php


/*
 * @name 删除文件
 *
 * @param string url
 *
 *
 *
 *
 */




$url=$_POST["url"];

include_once("../file/delete.php");

echo deleteFile($_SERVER['DOCUMENT_ROOT'].$url);