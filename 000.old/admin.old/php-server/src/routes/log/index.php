<?php



$router->addGroup("/log", function (FastRoute\RouteCollector $router) {
  $router->addRoute("POST", "/insert", 'insert_log');
  $router->addRoute("POST", "/delete", 'delete_log');
  $router->addRoute("POST", "/list", "select_log_list");
  $router->addRoute("POST", "/channel", "select_log_channel_list");
});
