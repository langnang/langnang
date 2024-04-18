<?php

use Langnang\Typecho\TypechoContentController;
use Langnang\Typecho\TypechoController;
use Langnang\Typecho\TypechoRelationshipController;
use Langnang\Typecho\TypechoMetaController;

$GLOBALS["ROUTER_PARAMS"]["delete_typecho_meta"] = array(
  "post" => array(
    "mids" => array(
      "desc" => "需要删除的标识编号列表",
      "type" => "array",
      "required" => true,
    ),
  )
);
/**
 * 根据标识编号（mids）批量删除博客标识数据
 *
 * @method POST
 * @param {Array} mids required 需要删除的数据编号
 * * 检测参数（mids）是否存在
 * * * 若不存在，返回（该标识数据不存在）
 * *
 */
function delete_typecho_meta(
  $data,
  $db = array(),
  // 该参数主要在内部调用的情况下使用
  $_options = array()
) {
  $_data = $data["post"];
  if (function_exists(str_replace("typecho", $_data["prefix"], __FUNCTION__))) return $data["error_messages"]["typecho_has_independent"];
  if (isset($_data["prefix"])) return $data["error_messages"]["typecho_has_prefix"];
  $_data["prefix"] = null;
  $_db = TypechoController::getDevConfig($_data["prefix"], $db);
  $_conn = Doctrine\DBAL\DriverManager::getConnection($_db);

  $mids = $_data["mids"];
  // 根据编号（mid）查询对应的数据
  $metas = select_typecho_meta(array("post" => array("mids" => $mids)))["rows"];
  $rows = [];
  $total = 0;
  foreach ($metas as $_meta) {
    // 若数据不存在
    if (is_string($_meta)) {
      array_push($rows, "删除失败，数据不存在");
      continue;
    }
    // 根据编号（mid）查询下一级标识
    $children_count = (new TypechoMetaController(
      array("parent" => $_meta->mid),
      $_conn,
      $_db
    ))->count();
    // 若该标识下存在子标识
    if ($children_count > 0) {
      array_push($rows, "删除失败，存在下一级");
      continue;
    }
    // 删除关联
    (new TypechoRelationshipController(array("mid" => $_meta->mid), $_conn, $_db))->delete();
    // 删除标识
    (new TypechoMetaController(array("mid" => $_meta->mid), $_conn, $_db))->delete();
    // 删除成功
    array_push($rows, TRUE);
    $total++;
  }

  return [
    "rows" => $rows,
    "total" => $total,
  ];
}
