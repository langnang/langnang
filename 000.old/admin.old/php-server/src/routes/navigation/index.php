<?php

use phpspider\core\requests;
use phpspider\core\selector;

$router->addGroup("/navigation", function (FastRoute\RouteCollector $router) {
  $router->addRoute("POST", "/insert", function ($data) {
  });

  /**
   * 查询
   */
  $router->addRoute("POST", "/select", function ($data) {
    $data = $data["post"];

    if (isset($data["url"]) && $data["url"] !== '') {
      $url = $data["url"];
      return select_navigation_by_crawler($url);
    }
  });
});

function insert_navigation()
{
}

/**
 * @param 根据URL爬取网页基本信息
 */
function select_navigation_by_crawler($url)
{
  $html = requests::get($url);

  $title = selector::select($html, "//title");

  $keywords = selector::select($html, "//meta[@name='keywords']/@content");

  $description = selector::select($html, "//meta[@name='description']/@content");

  $icon = selector::select($html, "//link[contains(@rel,'shortcut')]/@href");

  return [
    "url" => $url,
    "title" => $title,
    "keywords" => $keywords,
    "description" => $description,
    "icon" => $icon
  ];
}
