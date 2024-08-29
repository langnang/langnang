<?php


$app = new \App\Application;

// var_dump($app);
$app->_autoload();

require_once __DIR__ . '/functions.php';

// var_dump(App\Core\Application::name());

// require_once __DIR__ . '/app/helpers.php';


// var_dump($app->config());

return $app;
