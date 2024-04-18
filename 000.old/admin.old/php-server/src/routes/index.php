<?php
require_once __DIR__ . "/../../../modules/template/Template.php";
require_once __DIR__ . "/../../../modules/array/Array.php";
require_once __DIR__ . "/../../../modules/crawler/Crawler.php";
require_once __DIR__ . "/../../../modules/sql/SQL.php";
require_once __DIR__ . "/../../../modules/typecho/Typecho.php";

$router->addRoute("GET", '/', function ($data) {
  return array_merge([
    "TITLE" => "Langnang's Pensonal PHP APIs"
  ], $_ENV);
});

foreach (auto_require(__DIR__) as $file) {
  include_once $file;
}

function auto_require($path)
{
  $files = array();
  if (is_dir($path)) {
    if (false != ($handle = opendir($path))) {
      while (false !== ($file = readdir($handle))) {
        //去掉"“.”、“..”以及带“.xxx”后缀的文件
        if ($file != "." && $file != "..") {
          $files = array_merge($files, auto_require($path . "/" . $file));
        }
      }
      closedir($handle);
    }
  } else {
    if (strpos($path, ".php") !== FALSE && strpos($path, ".test.php") === FALSE) {
      array_push($files, $path);
    }
  }
  return $files;
}
