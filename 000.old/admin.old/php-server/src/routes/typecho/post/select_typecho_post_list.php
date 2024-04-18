<?php

use \Doctrine\DBAL\DriverManager;
use Langnang\Typecho\TypechoContentController;
use Langnang\Typecho\TypechoController;
use Langnang\Typecho\TypechoFieldController;
use Langnang\Typecho\TypechoPostModel;
use Langnang\Typecho\TypechoRelationshipController;

$GLOBALS["ROUTER_PARAMS"]["select_typecho_post_list"] = array(
  "post" => array(
    "prefix" => array(
      "desc" => "主、副表前缀",
      "type" => "string",
      "weight" => 999
    ),
    "mids" => array(
      "desc" => "关联标识的编号",
      "type" => "array",
      "weight" => 99
    ),
    "fields" => array(
      "description" => "关联的属性",
      "type" => "array",
      "weight" => 98
    ),
    "title" => array(
      "desc" => "文章标题...",
      "type" => "string",
      "weight" => 9
    ),
    "page" => array(
      "desc" => "页码",
      "type" => "int",
      "required" => true,
      "default" => 1,
    ),
    "size" => array(
      "desc" => "每页条数",
      "type" => "int",
      "required" => true,
      "default" => 10,
    ),
  )
);
/**
 * 根据条件查询博客文章列表
 */
function select_typecho_post_list(
  $data,
  $db = array(),
  // 该参数主要在内部调用的情况下使用
  $_options = array(
    "contents" => [], // 已查询的Content, 若数量大于1, 则使用该参数
    "is_call_content_count" => TRUE, // 是否调用Content的统计方法，避免无效查询
  )
) {
  $_data = $data["post"];
  $_db = TypechoController::getDevConfig($_data["prefix"], $db);
  $_conn = Doctrine\DBAL\DriverManager::getConnection($_db);
  $rows = [];
  $total = 0;
  // 多库查询
  if ($_db["prefix"] == "*") {
    $tbs = select_typecho_option_list($data)["rows"];
    foreach ($tbs as $tb) {
      $data["post"]["prefix"] = $tb["prefix"];
      $tb["data"] = select_typecho_post_list($data, $db, $_options);
      array_push($rows, $tb);
      $total++;
    }
    return array(
      "rows" => $rows,
      "total" => $total,
    );
  }
  // 单一库查询
  $meta_cids = null;
  $field_cids = null;
  // 根据标识关联查询
  if (isset($_data["mids"]) && sizeof($_data["mids"]) > 0) {
    $mids = $_data["mids"];
    $metas = (new TypechoRelationshipController($_data, $_conn, $_db))->list(array("mids" => $mids));
    $meta_cids = array_map(function ($item) {
      return $item->cid;
    }, $metas);
    if (count($meta_cids) == 0) return [
      "rows" => $rows,
      "size" => $_data["size"],
      "page" => $_data["page"],
      "total" => $total,
    ];
    // $data["post"]["cids"] = $cids;
    // return select_typecho_post($data, $db);
  }
  // 根据属性关联查询
  if (isset($_data["fields"]) && sizeof($_data["fields"]) > 0) {
    $_fields = $_data["fields"];
    $field_cids = NULL;
    foreach ($_fields as $key => $_field) {
      $_field_cids = array_map(function ($item) {
        return $item->cid;
      }, (new TypechoFieldController($_field, $_conn, $_db))->list());
      if (is_null($field_cids)) {
        $field_cids = $_field_cids;
      } else {
        $field_cids = array_intersect($field_cids, $_field_cids);
      }
      if (count($field_cids) == 0) {
        return [
          "rows" => $rows,
          "size" => $_data["size"],
          "page" => $_data["page"],
          "total" => $total,
        ];
      }
    }
  }
  if (!is_null($meta_cids) || !is_null($field_cids)) {
    $cids = [];
    if (!is_null($meta_cids)) {
      $cids = $meta_cids;
    } else if (!is_null($field_cids)) {
      $cids = $field_cids;
    } else {
      $cids = array_intersect($meta_cids, $field_cids);
    }
    $cids = array_slice($cids, ($_data["page"] - 1) * $_data["size"], $_data["size"]);
    if (count($cids) == 0) {
      return [
        "rows" => $rows,
        "size" => $_data["size"],
        "page" => $_data["page"],
        "total" => $total,
      ];
    }
    $data["post"]["cids"] = $cids;
    return array_merge(
      select_typecho_post($data, $db),
      array(
        "size" => $_data["size"],
        "page" => $_data["page"],
      )
    );
  }

  //
  if (count($_options["contents"]) == 0) {
    // 查询出所有符合的文章
    $contents = (new TypechoContentController($_data, $_conn, $_db))->list($_data);
  } else {
    $contents = $_options["contents"];
  }
  // 依据文章查询关联属性
  foreach ($contents as $_content) {
    $cid = $_content->cid;
    $_contents = select_typecho_post(["post" => ["cids" => [$cid]]], $db, [
      "is_call_content_select" => FALSE,
    ])["rows"];
    $post = new TypechoPostModel(array_merge((array)$_contents[0], (array)$_content));
    array_push($rows, $post);
  }

  if ($_options["is_call_content_count"] === TRUE) {
    $total = (new TypechoContentController($_data, $_conn, $_db))->count();
  }
  return [
    "rows" => $rows,
    "size" => $_data["size"],
    "page" => $_data["page"],
    "total" => (int)$total
  ];
}
