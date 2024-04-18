<?php


/*
 * @name readFile 读取文件内容
 *
 * @param string url
 *
 *
*/

include_once("../file/read.php");



echo readFileContent($_SERVER['DOCUMENT_ROOT'].$_POST["url"]);