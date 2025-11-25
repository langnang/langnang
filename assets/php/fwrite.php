<?php

$content = "| " . date("Y-m-d H:i:s") . " | info | 200 | Success |\n";
$filename = __DIR__ . DIRECTORY_SEPARATOR . ".log";

// 打开文件
$file = fopen($filename, "a");

// 写入内容到文件
fwrite($file, $content);

// 关闭文件
fclose($file);


echo $content;