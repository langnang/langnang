<?php

$router->addGroup("/user", function (FastRoute\RouteCollector $router) {
  // // 单件新增、批量新增
  $router->addRoute("POST", "/insert", "insert_typecho_user");
  // // 单件删除、批量删除
  $router->addRoute("POST", "/delete", "delete_typecho_user");
  // // 单件更新、批量更新
  $router->addRoute("POST", "/update", "update_typecho_user");
  // // 单件查询、批量查询
  $router->addRoute("POST", "/info", "select_typecho_user");
  // // 列表查询
  $router->addRoute("POST", "/list", "select_typecho_user_list");
  $router->addRoute("POST", "/login", "select_typecho_user_login");
  $router->addRoute("POST", "/logout", "select_typecho_user_logout");
});
