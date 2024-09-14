<?php

require_once __DIR__ . '/../vendor/autoload.php';

$_ENV = parse_ini_file(__DIR__ . '/../.env');
// var_dump($_ENV);
$app = new Illuminate\Application\Application(
  $_ENV['APP_BASE_PATH'] ?? dirname(__DIR__)
);

require_once __DIR__ . '/../illuminate/Application/helpers.php';
// require_once __DIR__ . '/../illuminate/Application/tests.php';

// var_dump($app);

$app->_autoload();

// var_dump(App\Core\Application::name());

// require_once __DIR__ . '/app/helpers.php';


// var_dump($app->config());

$app->_run();

return $app;
