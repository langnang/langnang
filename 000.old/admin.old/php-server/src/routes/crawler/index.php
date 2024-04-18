<?php

$router->addGroup("/crawler", function (FastRoute\RouteCollector $router) {
  // 测试
  $router->addRoute("POST", "/test", 'test_crawler_post');
  $router->addRoute("POST", "/insert", 'insert_crawler_post');
  $router->addRoute("POST", "/delete", 'delete_crawler_post');
  // 修改状态，执行
  $router->addRoute("POST", "/update", 'update_crawler_post');
  $router->addRoute("POST", "/list", 'select_crawler_post_list');
  $router->addRoute("POST", "/info", 'select_crawler_post');
});
