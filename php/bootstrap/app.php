<?php


$app = new \App\Core\Application;

// var_dump($app);
$app->__autoload();

require_once __DIR__ . '/functions.php';

// var_dump(App\Core\Application::name());

// require_once __DIR__ . '/app/helpers.php';


// var_dump($app->config());

return $app;
