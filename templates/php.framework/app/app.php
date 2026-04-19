<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../illuminates/Core/Illuminate.php';
require_once __DIR__ . '/../illuminates/Core/Traits/AliasesTrait.php';
require_once __DIR__ . '/../illuminates/Application/Application.php';

$_ENV = parse_ini_file(__DIR__ . '/../.env');
// var_dump([[$_ENV]]);
$app = new Illuminates\Application\Application(
  $_ENV['APP_BASE_PATH'] ?? dirname(__DIR__)
);


// 加载全局方法
require_once __DIR__ . '/helpers.php';
// require_once __DIR__ . '/../illuminate/Application/tests.php';

// var_dump($app);
// 调用生命周期方法
$app->_call('_autoload');

// var_dump(App\Core\Application::name());

// require_once __DIR__ . '/app/helpers.php';


// var_dump($app->config());
return $app;
