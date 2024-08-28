<?php


require_once __DIR__ . '/vendor/autoload.php';

$app = new App\Core\Application();

// var_dump(App\Core\Application::name());
require_once __DIR__ . '/app/helpers.php';

var_dump($app);

require_once __DIR__ . '/routes/api.php';
require_once __DIR__ . '/routes/web.php';


// $router = new \App\Core\Router;

// var_dump($router);

// $router->get('/', function () { });

$app->run();
