<?php

use Langnang\Typecho\TypechoController;
use Langnang\Typecho\TypechoMetaController;

$GLOBALS["ROUTER_PARAMS"]["select_typecho_meta_list"] = array(
  "post" => array(
    "name" => array(
      "desc" => "标识名称",
      "type" => "string",
    ),
    "type" => array(
      "desc" => "标识类型",
      "type" => "string",
    ),
    "parent" => array(
      "desc" => "上一级标识编号",
      "type" => ["int", "null"],
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
/**
 * 根据条件查询博客标识列表数据
 * * 名称
 * * 类型
 * * 上一级编号
 */
function select_typecho_meta_list($data, $db = array())
{
  $_data = $data["post"];
  $db = TypechoController::getDevConfig($_data["prefix"], $db);
  $conn = Doctrine\DBAL\DriverManager::getConnection($db);
  $rows = (new TypechoMetaController(
    $_data,
    $conn,
    $db
  ))->list($_data);

  $total = (new TypechoMetaController(
    $_data,
    $conn,
    $db
  ))->count();
  return [
    "rows" => $rows,
    "total" => $total,
    "size" => (int)$_data["size"],
    "page" => (int)$_data["page"],
  ];
}
