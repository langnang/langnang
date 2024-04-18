<?php

$router->addGroup("/quote", function (FastRoute\RouteCollector $router) {
  $router->addRoute("POST", "/insert", 'insert_quote');
  $router->addRoute("POST", "/list", 'select_quote_list');
  $router->addRoute("POST", "/info", 'select_quote_info');
});
