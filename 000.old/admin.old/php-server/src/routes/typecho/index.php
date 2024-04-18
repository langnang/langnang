<?php

/**
 * 适配于Typecho博客程序的接口服务
 * 主要功能配置在 /env.ini 文件中的 typecho 数据中
 * 以 prefix = typecho__ 的数据表作为主表
 * 根据 typecho__metas 表中 type = branch 作为副表（视图）的主要依据，分门别类，生成多种多样的
 * 主表拥有修改功能，副表只可查询
 * 若副表衍生出独立接口，则为避免编辑器兼容问题，禁止公用接口新增、修改、删除等会产生影响的操作
 */

$router->addGroup("/typecho", function (FastRoute\RouteCollector $router) {

  $router->addGroup("/meta", function (FastRoute\RouteCollector $router) {
    // 单件新增、批量新增
    $router->addRoute("POST", "/insert", "insert_typecho_meta");
    // 单件删除、批量删除
    $router->addRoute("POST", "/delete", "delete_typecho_meta");
    // 单件更新、批量更新
    $router->addRoute("POST", "/update", "update_typecho_meta");
    // 标识类型列表查询
    $router->addRoute("POST", "/type", "select_typecho_meta_type_list");
    $router->addRoute("POST", "/info", "select_typecho_meta");
    // 列表查询
    $router->addRoute("POST", "/list", "select_typecho_meta_list");
    // 树型查询
    $router->addRoute("POST", "/tree", "select_typecho_meta_tree");
  });
  $router->addGroup("/content", function (FastRoute\RouteCollector $router) {
  });
  $router->addGroup("/option", function (FastRoute\RouteCollector $router) {
    $router->addRoute("POST", "/replace", "replace_typecho_option");
    $router->addRoute("POST", "/info", "select_typecho_option");
    $router->addRoute("POST", "/list", "select_typecho_option_list");
  });

  $router->addGroup("/post", function (FastRoute\RouteCollector $router) {
    // 单件新增、批量新增
    $router->addRoute("POST", "/insert", "insert_typecho_post");
    // 单件删除、批量删除
    $router->addRoute("POST", "/delete", "delete_typecho_post");
    // 单件更新、批量更新
    $router->addRoute("POST", "/update", "update_typecho_post");
    // 单件查询、批量查询
    $router->addRoute("POST", "/info", "select_typecho_post");
    // 列表查询
    $router->addRoute("POST", "/list", "select_typecho_post_list");
    // 随机列表查询
    $router->addRoute("GET", "/random", "select_typecho_post_random");
  });
});
