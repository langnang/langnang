<?php

use Langnang\Typecho\TypechoContentController;
use Langnang\Typecho\TypechoController;
use Langnang\Typecho\TypechoFieldController;
use Langnang\Typecho\TypechoMetaController;

$GLOBALS["ROUTER_PARAMS"]["insert_typecho_field"] = array(
  "post" => array(
    "cid" => array(
      "desc" => "关联的内容编号",
      "type" => "int",
      "required" => true,
    ),
    "name" => array(
      "desc" => "字段名称",
      "type" => "string",
      "required" => true,
    ),
    "value" => array(
      "desc" => "字段值",
      "type" => ["string", "int", "float"],
      "required" => true,
    ),
  )
);
/**
 * 新增单条博客标识数据
 */
function insert_typecho_field($data, $db = array())
{

  $_data = $data["post"];
  if (function_exists(str_replace("typecho", $_data["prefix"], __FUNCTION__))) return $data["error_messages"]["typecho_has_independent"];
  if (isset($_data["prefix"])) return $data["error_messages"]["typecho_has_prefix"];
  $_db = TypechoController::getDevConfig($_data["prefix"], $db);
  $_conn = Doctrine\DBAL\DriverManager::getConnection($_db);
  $field = new TypechoFieldController($_data, $_conn, $_db);

  // 检测数据是否已存在
  if ($field->is_exists()) return "新增失败，数据已存在";

  if ($field->insert() === FALSE) return "新增失败";
  // 新增成功后查询数据
  $field->select();
  return $field;
}
