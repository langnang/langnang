<?php

use Langnang\Typecho\TypechoController;
use Langnang\Typecho\TypechoContentController;
use Langnang\Typecho\TypechoMetaController;
use Langnang\Typecho\TypechoOptionController;

$GLOBALS["ROUTER_PARAMS"]["select_typecho_option"] = array(
  "post" => array(
    "prefix" => array(
      "desc" => "表前缀",
      "type" => "string",
      "required" => true,
      "default" => "",
    ),
    "names" => array(
      "desc" => "配置名称",
      "type" =>  "array",
      "required" => true,
      "default" => ["*"]
    ),
  )
);
/**
 * 查询博客配置
 */
function select_typecho_option($data, $db = array())
{
  $_data = $data["post"];
  $_user = $data["user"];
  $_db = TypechoController::getDevConfig($_data["prefix"]);
  $_conn = \Doctrine\DBAL\DriverManager::getConnection($_db);
  $result = (new TypechoOptionController(array(
    "user" => $_user->uid,
  ), $_conn, $_db))->list(array("names" => $_data["names"]));
  // 配置名称黑名单
  $optionBlackList = ["routingTable", "secret"];
  $options = [];
  foreach ($result as $item) {
    if (array_search($item->name, $optionBlackList) === FALSE) {
      $options[$item->name] = $item->value;
    }
  }
  // 前缀
  if (array_search("*", $_data["names"]) !== FALSE || array_search("prefix", $_data["names"]) !== FALSE) $options["prefix"] = $_data["prefix"];
  // 统计文章数量
  if (array_search("*", $_data["names"]) !== FALSE || array_search("content_count", $_data["names"]) !== FALSE) $options["content_count"] = (new TypechoContentController(array(), $_conn, $_db))->count();
  if (array_search("*", $_data["names"]) !== FALSE || array_search("content_count", $_data["names"]) !== FALSE) $options["meta_count"] = (new TypechoMetaController(array(), $_conn, $_db))->count();
  return array(
    "rows" => $options,
    "total" => sizeof($options),
  );
}
