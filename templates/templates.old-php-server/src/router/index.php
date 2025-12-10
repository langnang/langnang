<?php



require_once __DIR__ . "/modules/swagger.php";

autoload_view([__DIR__ . "/../views/"]);


function autoload_view($paths = [])
{
  // foreach ($paths as $path) {
  //   var_dump($path);
  //   $files = array();
  //   if (false != ($handle = opendir($path))) {
  //     while (false !== ($file = readdir($handle))) {
  //       //去掉"“.”、“..”以及带“.xxx”后缀的文件
  //       if ($file != "." && $file != "..") {
  //         if (is_dir($path . "/" . $file)) {
  //           $files = array_merge($files, autoload_routes($path . "/" . $file));
  //         } else
  //       if ($file != "autoload.php" && strpos($file, ".php")) {
  //           array_push($files, $path . "/" . $file);
  //         }
  //       }
  //     }
  //     //关闭句柄
  //     closedir($handle);
  //   }
  //   return $files;
  // }
}
