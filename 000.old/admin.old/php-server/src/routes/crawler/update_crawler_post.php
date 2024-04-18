<?php

use Langnang\Component\Crawler\CrawlerController;

$GLOBALS["ROUTER_PARAMS"]["update_crawler_post"] = array(
  "post" => array(
    "id" => array(
      "desc" => "文章编号",
      "type" => "int",
      "required" => true
    ),
  )
);
/**
 * 根据条件（id）修改爬虫配置数据
 */
// 根据ID查询配置信息
function update_crawler_post($data)
{
  $_data = $data["post"];
  $id = $_data["id"];
  $rows = select_crawler_post(array("post" => array("ids" => array($id))))["rows"];
  $row = $rows[0];
  $post = CrawlerController::to_typecho_post(array_merge((array)$row, $_data));
  // var_dump($post);
  return update_typecho_post(array("post" => $post));
  return [
    "rows" => $rows,
  ];
  // update_crawler_post(array("post" => array(
  //   "cid" => $_data["id"],
  // )));
  $post = $data["post"];
  $post["cid"] = $post["id"];
  $post["title"] = $post["name"];
  $post["text"] = json_encode($post, JSON_UNESCAPED_UNICODE);
  $data["post"] = $post;
  // $result = update_typecho_post($data, $db);
  // return $result;
}
