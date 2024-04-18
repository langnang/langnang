<?php

use Langnang\Typecho\TypechoController;
use Langnang\Typecho\TypechoContentController;
use Langnang\Typecho\TypechoMetaController;
use Langnang\Typecho\TypechoOptionController;

$GLOBALS["ROUTER_PARAMS"]["replace_typecho_option"] = array(
  "post" => array(
    "prefix" => array(
      "desc" => "表前缀",
      "type" => "string",
      "required" => true,
      "default" => "",
    ),
    "options" => array(
      "desc" => "配置参数键值对",
      "type" =>  "array",
      "required" => true,
    ),
  )
);
/**
 * 查询博客配置
 */
function replace_typecho_option($data, $db = array())
{
  $_data = $data["post"];
  $_user = $data["user"];
  $_db = TypechoController::getDevConfig($_data["prefix"], $db);
  $_conn = \Doctrine\DBAL\DriverManager::getConnection($_db);

  $rows = [];
  $total = 0;
  foreach ($_data["options"] as $name => $value) {
    if ((new TypechoOptionController(array(
      "user" => $_user->uid,
      "name" => $name,
      "value" => $value,
    ), $_conn, $_db))->replace() === FALSE) {
      array_push($rows, FALSE);
    } else {
      array_push($rows, TRUE);
      $total++;
    }
  }
  return [
    "rows" => $rows,
    "total" => $total,
  ];
}
