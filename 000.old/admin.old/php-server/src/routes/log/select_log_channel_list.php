<?php
$GLOBALS["ROUTER_PARAMS"]["select_log_channel_list"] = array(
  "post" => array()
);
function select_log_channel_list($data)
{
  $_data = $data["post"];
  $_db = array_merge($GLOBALS["env_config"]["__cloud__"], $GLOBALS["env_config"]["log"]);
  $_dbname = $_db["dbname"];
  $_tbname = $_db["tbname"];
  $_conn = Doctrine\DBAL\DriverManager::getConnection($_db);

  $rows = array_map(function ($item) {
    return $item["channel"];
  }, $_conn->fetchAllAssociative("SELECT DISTINCT `channel` FROM `$_dbname`.`$_tbname` ;", array()));
  $total = sizeof($rows);
  return array(
    "rows" => $rows,
    "total" => $total,
  );
}
