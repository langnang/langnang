<?php

use Langnang\Typecho\TypechoContentController;
use Langnang\Typecho\TypechoController;

$GLOBALS["ROUTER_PARAMS"]["select_typecho_option_list"] = array(
  "post" => array(
    "prefix" => array(
      "desc" => "需要查询的配置表",
      "type" => "string",
      "required" => true,
      "default" => "",
    ),
    "names" => array(
      "desc" => "配置名称",
      "type" =>  "array",
      "required" => true,
      "default" => ["*"]
    ),
  )
);

function select_typecho_option_list($data, $db = array())
{
  $_data = $data["post"];
  $_db = TypechoController::getDevConfig($_data["prefix"], $db);
  $_conn = \Doctrine\DBAL\DriverManager::getConnection($_db);
  if ($_data["prefix"] === "*") {
    $dbname = $_db["dbname"];
    $sql = "SELECT `TABLE_NAME` FROM `INFORMATION_SCHEMA`.`TABLES`
    WHERE `TABLE_SCHEMA` = '$dbname'
    AND `TABLE_NAME` like 'typecho_%_options'
  ";

    $tbs = $_conn->fetchAllAssociative($sql);
    $rows = array();
    $total = 0;
    foreach ($tbs as $tb) {
      $prefix = substr($tb["TABLE_NAME"], 0, strlen($tb["TABLE_NAME"]) - 7);
      $prefix = substr($prefix, 8, -1);
      // 检测是否在全局环境中配置
      if (isset($_db["prefix_" . $prefix])) {
        $data["post"]["prefix"] = $prefix;
        $tb_options = select_typecho_option($data, $db);
        $tb_options["rows"]["total"] = $tb_options["total"];
        // $options["prefix"] = $prefix;
        array_push($rows, $tb_options["rows"]);
        $total++;
      }
    }
    return [
      "rows" => $rows,
      "total" => $total,
    ];
  }
  return select_typecho_option($data, $db);
}
