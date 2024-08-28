<?php

use \App\Support\Facades\Router;
use \App\Support\Facades\View;

$app->router->get('', function ($router) use ($app) {
  View::make('index', ['title' => "Langnang"]);
});
$app->router->get('/', function ($router) use ($app) {
  $app->view->render('Hello');
});
$app->router->get('/article', function ($router) use ($app) {
  $app->view->render('article');
});
$app->router->get('/title', function ($router) use ($app) {
  $app->view->render('title');
});

Router::get('/123123', function () {
  echo "123";
});
Router::post('/123123', function () {
  echo "123";
});
// $app->config();
