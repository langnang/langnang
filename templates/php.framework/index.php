<?php


$app = require_once __DIR__ . '/app/app.php';

if (!file_exists(__DIR__ . '/.env')) {
  file_exists('./install.php') ? header('Location: install.php') : print('Missing Config File');
}


$app->_run();

// dump($app);
// dump(Router::getRoutes());

if (env('APP_DEBUG')) {
  require_once __DIR__ . '/debug.php';
}

return $app;
