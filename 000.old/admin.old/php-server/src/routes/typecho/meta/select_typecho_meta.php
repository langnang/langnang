<?php

use Langnang\Typecho\TypechoContentController;
use Langnang\Typecho\TypechoController;
use Langnang\Typecho\TypechoFieldController;
use Langnang\Typecho\TypechoMetaController;

$GLOBALS["ROUTER_PARAMS"]["select_typecho_meta"] = array(
  "post" => array(
    "mids" => array(
      "desc" => "需要查询的标识编号列表",
      "type" => "array",
      "required" => true,
    ),
  )
);
/**
 * 根据标识编号（mids）批量查询博客标识数据
 */
function select_typecho_meta($data, $db = array())
{
  $_data = $data["post"];
  $_db = TypechoController::getDevConfig($_data["prefix"], $db);
  $_conn = Doctrine\DBAL\DriverManager::getConnection($_db);

  $mids = $_data["mids"];
  $rows = [];
  $total = 0;
  foreach ($mids as $_mid) {
    // 标识不可为空
    if (is_null($_mid) || $_mid == '') {
      array_push($rows, "查询失败，编号不可为空");
      continue;
    }
    $meta = new TypechoMetaController(array("mid" => $_mid), $_conn, $_db);
    if ($meta->select() === FALSE) {
      array_push($rows, "查询失败，数据不存在");
    } else {
      array_push($rows, $meta);
      $total++;
    }
  }
  return [
    "rows" => $rows,
    "total" => $total,
  ];
}
