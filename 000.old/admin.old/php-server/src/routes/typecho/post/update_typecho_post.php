<?php

use Langnang\Typecho\TypechoContentController;
use Langnang\Typecho\TypechoController;
use Langnang\Typecho\TypechoMetaController;
use Langnang\Typecho\TypechoFieldController;
use Langnang\Typecho\TypechoRelationshipController;
use Langnang\Typecho\TypechoPostModel;

$GLOBALS["ROUTER_PARAMS"]["update_typecho_post"] = array(
  "post" => array(
    "cid" => array(
      "desc" => "需要修改的文章编号",
      "type" => "int",
      "required" => true,
    ),
    "fields" => array(
      "desc" => "关联的属性",
      "type" => "array",
      "default" => [],
    ),
    "metas" => array(
      "desc" => "关联的标识",
      "type" => "array",
      "default" => [],
    ),
  )
);

/**
 * 根据条件（cid）修改博客文章数据
 *
 */
function update_typecho_post($data, $db = array())
{
  $_data = $data["post"];
  if (function_exists(str_replace("typecho", $_data["prefix"], __FUNCTION__))) return $data["error_messages"]["typecho_has_independent"];
  if (isset($_data["prefix"])) return $data["error_messages"]["typecho_has_prefix"];
  $_data["prefix"] = null;
  $_db = TypechoController::getDevConfig($_data["prefix"], $db);
  $_conn = Doctrine\DBAL\DriverManager::getConnection($_db);

  $_cid = $_data["cid"];
  $fields = [];
  $_fields = $_data["fields"];
  $metas = [];
  $_metas = $_data["metas"];
  // 修改文章基本信息
  $content = new TypechoContentController(array("cid" => $_cid), $_conn, $_db);
  $content->select();
  $content->__construct($_data, $_conn, $_db);
  $content->update();
  // 删除属性
  (new TypechoFieldController(array("cid" => $_cid), $_conn, $_db))->delete();
  // 新增属性
  if (sizeof($_fields) > 0) {
    foreach ($_fields as $field) {
      $field = new TypechoFieldController($field, $_conn, $_db);
      $field->__set("cid", $content->cid);
      $field->insert();
      array_push($fields, $field);
    }
  }
  // 删除关联
  (new TypechoRelationshipController(array("cid" => $_cid), $_conn, $_db))->delete();
  // 关联标识
  if (sizeof($_metas) > 0) {
    foreach ($_metas as $meta) {
      $meta = new TypechoMetaController($meta, $_conn, $_db);
      if (is_null($meta->mid)) {
        $meta->insert();
        $meta->select_mid();
      }
      $meta->select();
      array_push($metas, $meta);
      $relationship = new TypechoRelationshipController(array("cid" => $content->cid, "mid" => $meta->mid), $_conn, $_db);
      $relationship->insert();
    }
  }

  $result = new TypechoPostModel(array_merge(array("metas" => $metas, "fields" => $fields), (array)$content,));
  return $result;
}
