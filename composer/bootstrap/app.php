<?php


$app = new \App\Application;

require_once __DIR__ . '/functions.php';
// require_once __DIR__ . '/tests.php';

// var_dump($app);
$app->_autoload();


// var_dump(App\Core\Application::name());

// require_once __DIR__ . '/app/helpers.php';


// var_dump($app->config());

return $app;
