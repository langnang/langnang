<?php

use Langnang\Component\Crawler\CrawlerController;

$GLOBALS["ROUTER_PARAMS"]["select_crawler_post"] = array(
  "post" => array(
    "ids" => array(
      "desc" => "需要查询的文章编号",
      "type" => "array",
      "required" => true,
    ),
  )
);
/**
 * 根据条件（ids）查询爬虫配置数据
 */
function select_crawler_post($data)
{
  $_data = $data["post"];
  $ids = $_data["ids"];
  $post = select_typecho_post(array(
    "post" => array(
      "cids" => $ids
    )
  ));

  $rows = array_map(function ($post) {
    return CrawlerController::from_typecho_post($post);
  }, $post["rows"]);
  return array(
    "rows" => $rows,
    "total" => $post["total"],
  );
}
