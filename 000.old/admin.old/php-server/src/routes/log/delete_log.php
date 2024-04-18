<?php
$GLOBALS["ROUTER_PARAMS"]["select_log_list"] = array(
  "post" => array(
    "ids" => array(
      "desc" => "需要删除的日志编号",
      "type" => "array",
    ),
  )
);

function delete_log($data)
{
  $_data = $data["post"];
  $_db = array_merge($GLOBALS["env_config"]["__cloud__"], $GLOBALS["env_config"]["log"]);
  $_dbname = $_db["dbname"];
  $_tbname = $_db["tbname"];
  $_conn = Doctrine\DBAL\DriverManager::getConnection($_db);

  $ids = $_data["ids"];
  $rows = $_conn->executeStatement("UPDATE `$_dbname`.`$_tbname` SET `delete` = 1 WHERE `id` IN (:ids) ;", array("ids" => $ids), array("ids" => \Doctrine\DBAL\Connection::PARAM_INT_ARRAY,));
  return array(
    "rows" => $rows,
    "total" => sizeof($ids),
  );
}
