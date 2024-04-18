<?php

use Langnang\Typecho\TypechoContentController;
use Langnang\Typecho\TypechoController;
use Langnang\Typecho\TypechoFieldController;
use Langnang\Typecho\TypechoMetaController;

$GLOBALS["ROUTER_PARAMS"]["insert_typecho_meta"] = array(
  "post" => array(
    "name" => array(
      "desc" => "标识名称",
      "type" => "string",
      "required" => true,
    ),
    "type" => array(
      "desc" => "标识类型",
      "type" => "string",
      "required" => true,
    ),
  )
);
/**
 * 新增单条博客标识数据
 */
function insert_typecho_meta($data, $db = array())
{

  $_data = $data["post"];
  if (function_exists(str_replace("typecho", $_data["prefix"], __FUNCTION__))) return $data["error_messages"]["typecho_has_independent"];
  if (isset($_data["prefix"])) return $data["error_messages"]["typecho_has_prefix"];
  $_db = TypechoController::getDevConfig($_data["prefix"], $db);
  $_conn = Doctrine\DBAL\DriverManager::getConnection($_db);
  $meta = new TypechoMetaController($_data, $_conn, $_db);

  // 检测数据是否已存在
  if ($meta->is_exists()) return "新增失败，数据已存在";

  if ($meta->insert() === FALSE) return "新增失败";
  // 查询所属编号
  $meta->select_mid();
  $meta->select();
  return $meta;
}
