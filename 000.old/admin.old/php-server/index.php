<?php

// 允许跨域请求
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, PUT, OPTIONS, PATCH, DELETE');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: Authorization, Content-Type, x-xsrf-token, x_csrftoken, Cache-Control, X-Requested-With');
header("Content-Security-Policy: upgrade-insecure-requests");
header('Content-Type: application/json');

if (strtoupper($_SERVER['REQUEST_METHOD']) == 'OPTIONS') {
  exit;
}
// IP 白名单
$ipWhiteList = ["127.0.0.1"];
// API
$apiWhiteList = ["/user/login", "/crawler/list", "/crawler/info", "/crawler/update"];
// 一般用于本地脚本，无法验证token
$ipApiWhiteList = ["/crawler/list", "/crawler/info", "/crawler/update"];
// 开发环境
if (strpos($_SERVER["HTTP_HOST"], "220.248.58.129") !== false) {
  $_ENV["ENVIRONMENT"] = "DEVELOPMENT";
  define("ENV_CONFIG", __DIR__ . "/../env.develop");
  $env_config = parse_ini_file(ENV_CONFIG, true);
}
// 预览、测试环境
else if (strpos($_SERVER["HTTP_HOST"], "106.13.199.4") !== false) {
  $_ENV["ENVIRONMENT"] = "PREVIEW";
  define("ENV_CONFIG", __DIR__ . "/../env.preview");
  $env_config = parse_ini_file(ENV_CONFIG, true);
}
// 生产环境
else if (strpos($_SERVER["HTTP_HOST"], "1.15.182.152") !== false) {
  $_ENV["ENVIRONMENT"] = "PRODUCTION";
  define("ENV_CONFIG", __DIR__ . "/../env.production");
  $env_config = parse_ini_file(ENV_CONFIG, true);
}
// 本地
else {
  $_ENV["ENVIRONMENT"] = "DEVELOPMENT.LOCAL";
  define("ENV_CONFIG", __DIR__ . "/../env.develop");
  $env_config = parse_ini_file(ENV_CONFIG, true);
  $env_config["__cloud__"] = array_merge($env_config["__cloud__"], isset($env_config["__local__"]) ? $env_config["__local__"] : array());
}

//  日志表
$log_tb = array_merge($env_config["__cloud__"], $env_config["log"]);
require_once 'vendor/autoload.php';
require_once 'src/utils/index.php';

$pdo = new PDO($log_tb["pdo"] . ":dbname=" . $log_tb["dbname"] . ";host=" . $log_tb["host"], $log_tb["user"], $log_tb["password"]);
$mySQLHandler = new MySQLHandler\MySQLHandler($pdo, $log_tb["tbname"], array('level_name', 'context', 'extra', 'delete'), \Monolog\Logger::DEBUG);

// 存储路由参数检测条件
$ROUTER_PARAMS = array();

// 配置路由
$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $router) {
  require_once 'src/routes/index.php';
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

$logger = new \Monolog\Logger($uri);

$logger->pushHandler($mySQLHandler);

switch ($routeInfo[0]) {
  case FastRoute\Dispatcher::NOT_FOUND:
    // ... 404 Not Found
    $result = "404 Not Found";
    break;
  case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
    $allowedMethods = $routeInfo[1];
    // ... 405 Method Not Allowed
    $result = "405 Method Not Allowed";
    break;
  case FastRoute\Dispatcher::FOUND:
    $handler = $routeInfo[1];
    $vars = $routeInfo[2];
    $request = array(
      "method" => $httpMethod,
      "url" => $uri,
      "get" => $_GET,
      "post" => is_null(json_decode(file_get_contents('php://input'), true))
        ? $_POST
        : json_decode(file_get_contents('php://input'), true),
      "vars" => $vars,
      // 保障提示一致
      "error_messages" => array(
        // 有独立接口
        "typecho_has_independent" => "为保障数据兼容，本服务将停止已有独立服务的功能支持，请访问对应服务。",
        // 保障数据安装，非主表禁止修改、删除等危险操作
        "typecho_has_prefix" => "为保障数据安全，已停止对非主服务的支持，请访问主服务。",
      ),
    );

    // Token 验证
    // 可跳过规则
    // 1. 请求方式为：GET
    // 2. 接口白名单
    // 3. IP 白名单 + IP 接口白名单
    if ($httpMethod === "GET") {
    } else if (array_search($uri, $apiWhiteList) !== FALSE) {
    } else if (array_search($_SERVER['REMOTE_ADDR'], $ipWhiteList) !== FALSE && array_search($uri, $ipApiWhiteList) !== FALSE) {
    } else {
      if (!isset($_SERVER["HTTP_AUTHORIZATION"]) || !function_exists('authentication_token')) {
        $result = "Authorization Token Error";
        break;
      }

      $AUTHORIZATION = $_SERVER["HTTP_AUTHORIZATION"];
      // var_dump(strpos($AUTHORIZATION, 'Bearer'));
      $auth_header = "Bearer";
      if (strpos($AUTHORIZATION, $auth_header) === FALSE) {
        $result = "Authorization Token Error";
        break;
      }
      $request["token"] = substr($AUTHORIZATION, strlen($auth_header) + 1);
      $user = call_user_func('authentication_token', $request);
      if ($user === FALSE) {
        $result = "Authorization Token Error";
        break;
      } else {
        $request["user"] = $user;
      }
    }

    // ... call $handler with $vars
    // 匿名函数
    if (is_object($handler)) {
      $result =  $handler($request);
    }
    // 函数
    else if (is_string($handler) && function_exists($handler)) {
      $result = router_params_exists($handler,);
      if ($result === TRUE)
        $result = call_user_func($handler, $request);
    }
    // 类中函数
    else if (is_array($handler) && method_exists($handler[0], $handler[1])) {
      $result = call_user_func($handler, $request);
    } else {
      $result = "404 Method Not Found";
    }
    break;
}
// 部分路由执行下面的操作
// if (array_search($uri, ["/"]) !== false) return;
// 输出结果
// 结果不存在或为字符串，返回404
if (!$result || is_string($result)) {
  $result = [
    "status" => 404,
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
  $status = isset($result["status"]) ? $result["status"] : 404;
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

// EMERGENCY (600): Emergency: system is unusable.
if ($result["status"] >= 600) {
  $level_name = 'EMERGENCY';
}
// ALERT (550): Action must be taken immediately. Example: Entire website down, database unavailable, etc. This should trigger the SMS alerts and wake you up.
else if ($result["status"] >= 550) {
  $level_name = 'ALERT';
}
// CRITICAL (500): Critical conditions. Example: Application component unavailable, unexpected exception.
else if ($result["status"] >= 500) {
  $level_name = 'CRITICAL';
}
// ERROR (400): Runtime errors that do not require immediate action but should typically be logged and monitored.
else if ($result["status"] >= 400) {
  $level_name = 'ERROR';
}
// WARNING (300): Exceptional occurrences that are not errors. Examples: Use of deprecated APIs, poor use of an API, undesirable things that are not necessarily wrong.
else  if ($result["status"] >= 300) {
  $level_name = 'WARNING';
}
// NOTICE (250): Normal but significant events.
else if ($result["status"] >= 250) {
  $level_name = 'NOTICE';
}
// INFO (200): Interesting events. Examples: User logs in, SQL logs.
else if ($result["status"] >= 200) {
  $level_name = 'INFO';
}
// DEBUG (100): Detailed debug information.
else if ($result["status"] >= 100) {
  $level_name = 'DEBUG';
} else if ($result["status"] < 100) {
}

$logger->{$level_name}($result["statusText"], array(
  'level_name' => $level_name,
  'context' => json_encode(array(
    "request" => $request,
    "response" => $result
  ), JSON_UNESCAPED_UNICODE),
  'extra' => NULL,
  'delete' => NULL,
));

echo json_encode($result, JSON_UNESCAPED_UNICODE);
