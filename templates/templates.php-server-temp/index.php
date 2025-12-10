<?php

// 允许跨域请求
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, PUT, OPTIONS, PATCH, DELETE');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: Authorization, Content-Type, x-xsrf-token, x_csrftoken, Cache-Control, X-Requested-With');

require_once 'vendor/autoload.php';
require_once 'modules/autoload.php';

// 配置路由
$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $router) {
  require_once 'routes/autoload.php';
});

// Fetch method and URI from somewhere
// 请求方式: GET, POST, PUT, PATCH, DELETE, HEAD
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
  $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

switch ($routeInfo[0]) {
  case FastRoute\Dispatcher::NOT_FOUND:
    // ... 404 Not Found
    echo "404 Not Found";
    break;
  case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
    $allowedMethods = $routeInfo[1];
    // ... 405 Method Not Allowed
    echo "405 Method Not Allowed";
    break;
  case FastRoute\Dispatcher::FOUND:
    $handler = $routeInfo[1];
    $vars = $routeInfo[2];
    $data = array(
      "method" => $httpMethod,
      "url" => $uri,
      "get" => $_GET,
      "post" => $_POST,
      "vars" => $vars,
    );
    // ... call $handler with $vars
    if (is_object($handler)) {
      $handler($data);
    } else if (is_string($handler) && function_exists($handler)) {
      call_user_func($handler, $data);
    } else if (is_array($handler) && method_exists($handler[0], $handler[1])) {
      call_user_func($handler, $data);
    }
    break;
}
