<?php

use Langnang\Typecho\TypechoController;
use Langnang\Typecho\TypechoMetaController;

/**
 * 查询博客标识表中的所有类型
 */
function select_typecho_meta_type_list($data, $db = array())
{
  $_data = $data["post"];
  $_db = TypechoController::getDevConfig($_data["prefix"], $db);
  $_conn = Doctrine\DBAL\DriverManager::getConnection($_db);

  $rows = (new TypechoMetaController(array(), $_conn, $_db))->type_list();
  return [
    "rows" => $rows,
    "total" => count($rows),
  ];
}
