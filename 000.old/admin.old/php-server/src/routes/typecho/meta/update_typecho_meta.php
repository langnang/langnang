<?php

use Langnang\Typecho\TypechoContentController;
use Langnang\Typecho\TypechoController;
use Langnang\Typecho\TypechoFieldController;
use Langnang\Typecho\TypechoMetaController;

$GLOBALS["ROUTER_PARAMS"]["update_typecho_meta"] = array(
  "post" => array(
    "mid" => array(
      "desc" => "标识编号",
      "type" => "int",
      "required" => true,
    ),
  )
);
function update_typecho_meta($data, $db = array())
{

  $_data = $data["post"];
  if (function_exists(str_replace("typecho", $_data["prefix"], __FUNCTION__))) return $data["error_messages"]["typecho_has_independent"];
  if (isset($_data["prefix"])) return $data["error_messages"]["typecho_has_prefix"];
  $mid = $_data["mid"];
  $db = TypechoController::getDevConfig($_data["prefix"], $db);
  $conn = Doctrine\DBAL\DriverManager::getConnection($db);

  $meta = new TypechoMetaController(array("mid" => $mid), $conn, $db);
  if ($meta->select() === FALSE) return "更新失败，数据不存在";
  $meta->__construct($_data, $conn, $db);
  $meta->update();
  return $meta;
}
