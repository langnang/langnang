<?php


$app->router->get('', function ($router) use ($app) {
    $app->view->render('Welcome');
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

$app->config();
