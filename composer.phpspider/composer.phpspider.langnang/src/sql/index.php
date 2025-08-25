<?php

$_SQL = [];

$_SQL['$'] = [
  "select_list" => function ($sql, $params = []) {
    $page = (int)($params['page'] ? $params['page'] : 1);
    $size = (int)($params['size'] ? $params['size'] : 10);
    return $sql . " LIMIT {$size} OFFSET " . (($page - 1) * $size);
  },
  "select_count" => function ($sql) {
    $sql = trim($sql);
    // 去除分页查询条件
    $sql = preg_split("/(limit)/i", $sql)[0];
    // 去除末尾的分号，以便于组合SQL
    $sql = substr($sql, -1) == ";" ? substr($sql, 0, -1) : $sql;
    return "SELECT COUNT(*) AS `COUNT` FROM (" . ($sql) . ") AS T_COUNT";
  },
  "select_exist" => function () {
  }
];
$_SQL['api'] = [];
require_once __DIR__ . "/api/sql.php";
