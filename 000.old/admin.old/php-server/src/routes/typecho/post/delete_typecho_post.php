<?php

use Langnang\Typecho\TypechoContentController;
use Langnang\Typecho\TypechoController;
use Langnang\Typecho\TypechoFieldController;
use Langnang\Typecho\TypechoRelationshipController;

$GLOBALS["ROUTER_PARAMS"]["delete_typecho_post"] = array(
  "post" => array(
    "cids" => array(
      "desc" => "需要删除的文章编号列表",
      "type" => "array",
      "required" => true,
    ),
  )
);
function delete_typecho_post(
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

  $cids = $_data["cids"];
  $rows = [];
  $total = 0;
  foreach ($cids as $_cid) {
    if (is_null($_cid)) {
      continue;
    }
    // 删除属性
    (new TypechoFieldController(array("cid" => $_cid), $_conn, $_db))->delete();
    // 删除关联
    (new TypechoRelationshipController(array("cid" => $_cid), $_conn, $_db))->delete();
    // 删除内容
    (new TypechoContentController(array("cid" => $_cid), $_conn, $_db))->delete();
    array_push($rows, TRUE);
    $total++;
  }
  return array(
    "rows" => $rows,
    "total" => $total,
  );
}
