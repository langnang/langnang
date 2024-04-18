<?php

use Langnang\Typecho\TypechoContentController;
use Langnang\Typecho\TypechoController;
use Langnang\Typecho\TypechoFieldController;
use Langnang\Typecho\TypechoMetaController;
use Langnang\Typecho\TypechoRelationshipController;
use Langnang\Typecho\TypechoPostModel;

$GLOBALS["ROUTER_PARAMS"]["insert_typecho_post"] = array(
  "post" => array(
    "title" => array(
      "desc" => "新增文章的标题",
      "type" => "string",
      "required" => true,
    ),
  )
);
function insert_typecho_post($data, $db = array())
{
  $_data = $data["post"];
  if (function_exists(str_replace("typecho", $_data["prefix"], __FUNCTION__))) return $data["error_messages"]["typecho_has_independent"];
  if (isset($_data["prefix"])) return $data["error_messages"]["typecho_has_prefix"];
  $_data["prefix"] = null;
  $_db = TypechoController::getDevConfig($_data["prefix"], $db);
  $_conn = Doctrine\DBAL\DriverManager::getConnection($_db);
  $_data["authorId"] = $data["user"]->uid;
  $content = new TypechoContentController($_data, $_conn, $_db);
  if ($content->is_exists()) return "新增失败，数据已存在";
  if ($content->insert() === FALSE) return "新增失败";
  $content->select_cid();
  $content->select();
  $fields = [];
  if (isset($_data["fields"])) {
    foreach ($_data["fields"] as $field) {
      $field = insert_typecho_field(array("post" => array(
        "cid" => $content->cid,
        "name" => $field["name"],
        "value" => $field["value"]
      )), $db);
      array_push($fields, $field);
    }
  }
  $metas = [];
  if (isset($_data["metas"])) {
    foreach ($_data["metas"] as $meta) {
      $meta = insert_typecho_meta(array("post" => $meta), $db);
      array_push($metas, $meta);
      $relationship = new TypechoRelationshipController(array("cid" => $content->cid, "mid" => $meta->mid), $_conn, $_db);
      $relationship->insert();
    }
  }
  $result = new TypechoPostModel(array_merge(array("metas" => $metas, "fields" => $fields), (array)$content,));
  return $result;
}
