<?php

use \Doctrine\DBAL\DriverManager;
use Langnang\Typecho\TypechoContentController;
use Langnang\Typecho\TypechoController;
use Langnang\Typecho\TypechoFieldController;
use Langnang\Typecho\TypechoMetaController;
use Langnang\Typecho\TypechoRelationshipController;
use Langnang\Typecho\TypechoPostModel;

$GLOBALS["ROUTER_PARAMS"]["select_typecho_post"] = array(
  "post" => array(
    "prefix" => array(),
    "cids" => array(
      "desc" => "需要查询的文章编号",
      "type" => "array",
      "required" => true,
    ),
  )
);
/**
 * 根据条件（cid）查询博客文章数据
 */
function select_typecho_post(
  $data,
  $db = array(),
  // 该参数主要在内部调用的情况下使用
  $_options = array(
    "is_call_content_select" => TRUE, // 是否调用Content的查询方法，避免重复查询
  )
) {
  $_data = $data["post"];
  $_db = TypechoController::getDevConfig($_data["prefix"], $db);
  $_conn = Doctrine\DBAL\DriverManager::getConnection($_db);

  $cids = $_data["cids"];
  $rows = array();
  $total = 0;

  foreach ($cids as $_cid) {
    $content = new TypechoContentController(array("cid" => $_cid), $_conn, $_db);
    // 是否查询Content内容，避免内部调用时重复查询重复查询
    if ($_options["is_call_content_select"] == TRUE) {
      if ($content->select() === FALSE) {
        return "数据不存在";
      }
    }
    // field 检索
    $fields = (new TypechoFieldController(array("cid" => $_cid), $_conn, $_db))->list();
    // meta 检索
    $relationships = (new TypechoRelationshipController(array("cid" => $_cid), $_conn, $_db))->list();

    $metas = array_map(function ($relationship) use ($_conn, $_db) {
      $meta = new TypechoMetaController(array("mid" => $relationship->mid), $_conn, $_db);
      $meta->select();
      return $meta;
    }, $relationships);
    $post = new TypechoPostModel(array_merge((array)$content, array("fields" => $fields, "metas" => $metas)));

    array_push($rows, $post);
    $total++;
  }

  return array(
    "rows" => $rows,
    "total" => $total,
  );
}
