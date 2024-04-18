
<?php

use Langnang\Component\Crawler\CrawlerController;

$GLOBALS["ROUTER_PARAMS"]["select_crawler_post_list"] = array(
  "post" => array(
    "title" => array(
      "desc" => "文章标题",
      "type" => "string",
      "default" => "",
    ),
    "page" => array(
      "desc" => "页码",
      "type" => "int",
      "required" => true,
      "default" => 1,
    ),
    "size" => array(
      "desc" => "每页条数",
      "type" => "int",
      "required" => true,
      "default" => 10,
    ),
  )
);
function select_crawler_post_list($data)
{
  $_data = $data["post"];
  $data["post"]["prefix"] = "crawler";
  $data["post"]["fields"] = [];
  if (isset($_data["status"])) array_push($data["post"]["fields"], array("name" => "status", "value" => $_data["status"]));

  $posts = select_typecho_post_list($data);
  $rows = $posts["rows"];
  $rows = array_map(function ($row) {
    return CrawlerController::from_typecho_post($row);
  }, $rows);
  return [
    "rows" => $rows,
    "size" => $posts["size"],
    "page" => $posts["page"],
    "total" => $posts["total"],
  ];
}
