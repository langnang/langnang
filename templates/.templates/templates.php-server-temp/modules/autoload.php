<?php

if (false != ($handle = opendir(__DIR__))) {
  while (false !== ($file = readdir($handle))) {
    //去掉"“.”、“..”以及带“.xxx”后缀的文件
    if ($file != "." && $file != "..") {
      if (is_dir(__DIR__ . "/" . $file)) {
        // $files = array_merge($files, autoload_routes($path . "/" . $file));
        require_once __DIR__ . "/" . $file . "/module.php";
      }
    }
  }
}
