<?php

/**
 * @OA\Info(
 *     description="php-web-server-apis",
 *     version="0.0.1",
 *     title="PHP Web Server APIs",
 *     @OA\Contact(
 *         email="langnang.chen@outlook.com"
 *     ),
 * )
 */
// openapi json for swagger
$router->addRoute("GET", '/', function ($data) {
  $openapi = \OpenApi\Generator::scan(["routes/"]);
  header('Content-Type: application/json');
  echo $openapi->toJson();
});
$router->addRoute('GET', '/users', 'get_all_users_handler');
// {id} must be a number (\d+)
$router->addRoute('GET', '/user/{id:\d+}', 'get_user_handler');
// The /{title} suffix is optional
$router->addRoute('GET', '/articles/{id:\d+}[/{title}]', 'get_article_handler');
$router->addGroup("/admin", function (FastRoute\RouteCollector $router) {
  // declaration
  $router->addRoute("GET", "", array(AdminModule::class, 'render_view'));
});
$router->addGroup("/install", function (FastRoute\RouteCollector $router) {
  // declaration
  $router->addRoute("GET", "/declaration", array(InstallModule::class, 'render_view_declaration'));
  // allocation
  $router->addRoute("GET", "/allocation", array(InstallModule::class, 'allocation'));
  // setup
  $router->addRoute("GET", "/setup", array(InstallModule::class, 'setup'));
  // consequence
  $router->addRoute("GET", "/consequence", array(InstallModule::class, 'consequence'));
});
// autoload routes
$files = autoload_routes(__DIR__);
foreach ($files as $file) {
  include_once $file;
}
function autoload_routes($path)
{
  $files = array();
  if (false != ($handle = opendir($path))) {
    while (false !== ($file = readdir($handle))) {
      //去掉"“.”、“..”以及带“.xxx”后缀的文件
      if ($file != "." && $file != "..") {
        if (is_dir($path . "/" . $file)) {
          $files = array_merge($files, autoload_routes($path . "/" . $file));
        } else
        if ($file != "autoload.php" && strpos($file, ".php")) {
          array_push($files, $path . "/" . $file);
        }
      }
    }
    //关闭句柄
    closedir($handle);
  }
  return $files;
}
