<?php

// 允许跨域请求
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, PUT, OPTIONS, PATCH, DELETE');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: Authorization, Content-Type, x-xsrf-token, x_csrftoken, Cache-Control, X-Requested-With');

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . "/src/sql/index.php";

$_ENV = array_merge($_ENV, parse_ini_file(__DIR__ . "/.env", true));
foreach ($_ENV['Environment'] ?: [] as $key => $name) {
  if ($name == $_SERVER['SERVER_NAME']) {
    $_ENV = array_merge($_ENV, parse_ini_file(__DIR__ . "/.env.{$key}", true));
    break;
  }
}
// 配置路由
$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $router) {
  require_once __DIR__ . "/src/api/index.php";
  require_once __DIR__ . "/src/router/index.php";
});
// Fetch method and URI from somewhere
// 请求方式: GET, POST, PUT, PATCH, DELETE, HEAD
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// if (substr($uri, 0, 2) !== '/?') {
//   header("Location:/?{$uri}");
// }
// $uri = substr($uri, 2);
// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri,  '?')) {
  $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

$result = null;

switch ($routeInfo[0]) {
  case FastRoute\Dispatcher::NOT_FOUND:
    // 未配路由的，且存在在视图目录，自动重定向
    if (substr($uri, -1, 1) == '/') {
      if (file_exists(__DIR__ . "/src/views" . $uri . "index.html")) $uri .= "index.html";
      else if (file_exists(__DIR__ . "/src/views" . $uri . "index.php")) $uri .= "index.php";
    }
    if ($httpMethod == 'GET' && file_exists(__DIR__ . "/src/views" . $uri) && pathinfo(__DIR__ . "/src/views" . $uri)['extension']) {
      switch (pathinfo(__DIR__ . "/src/views" . $uri)['extension']) {
        case "php":
          require_once __DIR__ . "/src/views" . $uri;
          return;
          break;
        case "css":
          header("Content-type: text/css");
          break;
        default:
          break;
      }
      echo file_get_contents(__DIR__ . "/src/views" . $uri);
    } else {
      echo file_get_contents(__DIR__ . "/src/views/404.html");
    }
    // ... 404 Not Found
    break;
  case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
    $allowedMethods = $routeInfo[1];
    // ... 405 Method Not Allowed
    echo "405 Method Not Allowed";
    break;
  case FastRoute\Dispatcher::FOUND:
    $handler = $routeInfo[1];
    $vars = $routeInfo[2];
    $_ENV['Route'] = array(
      "method" => $httpMethod,
      "path" => $uri,
      "vars" => $vars,
    );
    if (sizeof($_GET) > 0) {
      $_GET[substr(array_key_first($_GET), strlen($uri) + 1)] = $_GET[array_key_first($_GET)];
    }
    if (!is_null(json_decode(file_get_contents('php://input'), true))) {
      $_POST = array_merge($_POST, json_decode(file_get_contents('php://input'), true));
    }
    // ... call $handler with $vars
    if (is_object($handler)) {
      $result = $handler();
    } else if (is_string($handler) && function_exists($handler)) {
      $result = call_user_func($handler);
    } else if (is_array($handler) && method_exists($handler[0], $handler[1])) {
      $result = call_user_func($handler);
    }
    break;
}

if (
  !is_null($_ENV['Result']['status'])
  && sizeof(array_filter(explode(',', $_ENV['Result']['status']), function ($path) {
    return preg_match($path, $_ENV['Route']['path']);
  })) > 0
) {
  // 输出结果
  // 结果不存在或为字符串，返回400
  if (!$result || is_string($result)) {
    $result = [
      "status" => 400,
      "statusText" => $result ? $result : "Error",
    ];
  } else if (is_object($result)) {
    $result = array(
      "status" => 200,
      "statusText" => 'Success',
      "data" => $result,
    );
  }
  // 如果存在状态码
  else if (isset($result["status"]) && is_numeric($result["status"])) {
    $status = isset($result["status"]) ? $result["status"] : 400;
    $statusText = isset($result["statusText"]) ? $result["statusText"] : "";
    if ($statusText == '') {
      switch ($status) {
        case 200:
          $statusText = "Success";
          break;
        default:
          $statusText = "Error";
          break;
      }
    }
    $result = array(
      "status" => $status,
      "statusText" => $statusText,
      "data" => $result["data"],
    );
  }
  // 不存在状态码，直接输出200
  else {
    // 存在参数data,取data值
    if (isset($result["data"])) {
      $result = array(
        "status" => 200,
        "statusText" => 'Success',
        "data" => $result["data"],
      );
    } else {
      $result = array(
        "status" => 200,
        "statusText" => 'Success',
        "data" => $result,
      );
    }
  }
  header('Content-Type: application/json');
  echo json_encode(array_filter((array)$result), JSON_UNESCAPED_UNICODE);
}
