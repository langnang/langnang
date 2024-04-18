<?php

header("Content-Type: application/json;");

require_once "./vendor/autoload.php";

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\FirePHPHandler;

// $faker = Faker\Factory::create();

$fs = new League\Flysystem\Filesystem(new League\Flysystem\Local\LocalFilesystemAdapter(__DIR__));

$conf = require_once __DIR__ . "/config.inc.php";

$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $route) {
  $route->addRoute("GET", '/', function ($vars) {
    $openapi = \OpenApi\Generator::scan(["src/"]);
    echo $openapi->toJson();
  });

  if (file_exists(__DIR__ . "/src/main.php")) {
    require_once __DIR__ . "/src/main.php";
  }
});

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
  $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$logger = new Logger("[" . getIP() . " " . $httpMethod . " " . $uri . "]");
$logger->pushHandler(new StreamHandler('.log/' . date("Y/m/d") . '.log', Logger::DEBUG));
$logger->pushHandler(new FirePHPHandler());


$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
  case FastRoute\Dispatcher::NOT_FOUND:
    $result = array(
      "status" => 404,
      "statusText" => "Not Found",
    );
    // ... 404 Not Found
    break;
  case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
    $allowedMethods = $routeInfo[1];
    $result = array(
      "status" => 405,
      "statusText" => "Method Not Allowed",
    );
    // ... 405 Method Not Allowed
    break;
  case FastRoute\Dispatcher::FOUND:
    $handler = $routeInfo[1];
    $vars = $routeInfo[2];
    // You can now use your logger
    $result = $handler($vars);
    // echo json_encode($result);
    // ... call $handler with $vars
    break;
}

// add records to the log
switch (strtolower($result["status"])) {
  case 405:
    $logger->warning($result["desc"], $routeInfo, ['username' => 'Seldaek']);
    break;
  case 404:
    $logger->error($result["desc"], $routeInfo, ['username' => 'Seldaek']);
    break;
  default:
    $logger->info($result["desc"], $routeInfo, ['username' => 'Seldaek']);
    break;
}
if (!$result) return;
echo json_encode(array(
  "status" => isset($result["status"]) ? $result["status"] : 404,
  "statusText" => isset($result["statusText"]) ? $result["statusText"] : "Not Found",
  "data" => $result["data"],
), JSON_UNESCAPED_UNICODE);

function getIP()
{
  global $ip;
  if (getenv("HTTP_CLIENT_IP")) {
    $ip = getenv("HTTP_CLIENT_IP");
  } else if (getenv("HTTP_X_FORWARDED_FOR")) {
    $ip = getenv("HTTP_X_FORWARDED_FOR");
  } else if (getenv("REMOTE_ADDR")) {
    $ip = getenv("REMOTE_ADDR");
  } else {
    $ip = "Unknow";
  }
  return $ip;
}
