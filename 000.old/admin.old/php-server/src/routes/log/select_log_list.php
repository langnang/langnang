<?php
$GLOBALS["ROUTER_PARAMS"]["select_log_list"] = array(
  "post" => array(
    "page" => array(
      "desc" => "页码",
      "type" => "int",
      "default" => 1,
    ),
    "size" => array(
      "desc" => "每页条数",
      "type" => "int",
      "default" => 10,
    ),
  )
);
function select_log_list($data)
{
  $_data = $data["post"];
  if (isset($_data["channel"])) {
    $channel = "%" . $_data["channel"] . "%";
  } else {
    $channel = '%%';
  }
  $_db = array_merge($GLOBALS["env_config"]["__cloud__"], $GLOBALS["env_config"]["log"]);
  $_dbname = $_db["dbname"];
  $_tbname = $_db["tbname"];
  $_conn = Doctrine\DBAL\DriverManager::getConnection($_db);

  $page = $_data["page"];
  $size = $_data["size"];
  $limit = $size;
  $offset = ($page - 1) * $size;

  $rows = array_map(function ($item) {
    $context = json_decode($item["context"], true);
    unset($item["context"]);
    if ($context === FALSE || is_null($context)) {
      return $item;
    }
    return array_merge(
      $item,
      $context
    );
  }, $_conn->fetchAllAssociative("SELECT * FROM `$_dbname`.`$_tbname` WHERE `channel` LIKE :channel AND `delete` IS NULL ORDER BY `id` DESC LIMIT $limit OFFSET $offset ;", array(
    'channel' => $channel
  )));
  $total = (int)$_conn->fetchOne("SELECT COUNT(*) FROM `$_dbname`.`$_tbname` WHERE `channel` LIKE :channel AND `delete` IS NULL ;", array(
    'channel' => $channel
  ));
  return array(
    "rows" => $rows,
    "page" => $page,
    "size" => $size,
    "total" => $total,
  );
}
