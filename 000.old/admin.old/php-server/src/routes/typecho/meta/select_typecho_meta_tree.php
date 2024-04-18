<?php

use Langnang\Component\ArrayAccess\ArrayController;
use Langnang\Typecho\TypechoController;
use Langnang\Typecho\TypechoMetaController;

$GLOBALS["ROUTER_PARAMS"]["select_typecho_meta_tree"] = array(
  "post" => array(
    "parent" => array(
      "desc" => "上一级标识编号",
      "type" => [
        "int", // mid
        "null", // 空
        "object" // {mid,name,type}
      ],
    ),
    "type" => array(
      "desc" => "标识类型",
      "type" => "string",
    ),
  )
);
/**
 * 根据条件查询博客标识树型数据
 *
 */
function select_typecho_meta_tree($data, $db = array())
{
  $_data = $data["post"];
  $_db = TypechoController::getDevConfig($_data["prefix"], $db);
  $_conn = Doctrine\DBAL\DriverManager::getConnection($_db);

  // 页码
  $_data["page"] = 1;
  // 每页条数
  $_data["size"] = 99999999;
  $rows = (new TypechoMetaController(
    $_data,
    $_conn,
    $_db
  ))->list($_data);

  $tree = ArrayController::to_tree(array_map(function ($item) {
    return json_decode(json_encode($item, JSON_UNESCAPED_UNICODE), true);
  }, $rows), 'mid', 'parent', 0);
  $total = (new TypechoMetaController(
    $_data,
    $_conn,
    $_db
  ))->count();
  return [
    "rows" => $rows,
    "tree" => $tree,
    "total" => $total,
  ];
}
