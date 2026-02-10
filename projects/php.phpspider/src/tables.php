<?php

use app\controllers\db;

$export = $currentConfig['export'];
$tbname = $export['table'];
if ($export['type'] !== 'db') return;

$db_config = $currentConfig['db_config'];
// 数据库配置
db::set_connect('default', $db_config);
// 数据库链接
db::_init();
$fields = $currentConfig["fields"];
// 数据库结构与规则一致
if (empty(db::get_all("SHOW TABLES LIKE '{$export['table']}'"))) {
  $sql = "CREATE TABLE `{$export['table']}`  (";
  $table_indexes = [];
  $table_primary_keys = [];
  foreach ($fields as $field) {
    if (!isset($field["name"]) || $field["name"] == "") {
      continue;
    }
    if ($field['data_index'] ?? false) array_push($table_indexes, $field["name"]);

    if ($field['primary_key'] ?? false) array_push($table_primary_keys, $field["name"]);

    $sql .= "\n\t`{$field['name']}` "
      . ($field['data_type'] ?? "text")
      . (($field['nullable'] ?? true) == true  ? ' NULL ' : " NOT NULL ")
      . (($field['auto_increment'] ?? false) == true  ? ' AUTO_INCREMENT ' : "")
      . " COMMENT '" . ($field['description'] ?? "") . "',";
  }

  if (sizeof($table_indexes) > 0) {
    $sql .= "\n\tUNIQUE INDEX {$export['table']}_index (" . implode(", ", $table_indexes) . "),";
  }

  if (sizeof($table_primary_keys) > 0) {
    $sql .= "\n\tPRIMARY KEY (" . implode(", ", $table_primary_keys) . ") USING BTREE,";
  }

  $sql = substr($sql, 0, -1) . "\n) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;";
  // "";
  // print($sql);
  // exit;
  $result = db::query($sql);
  var_dump($result);
} else if (false) {
  // 查询表中所有
  $columns = db::get_all("DESC `{$export['table']}`");
  // print_r($columns);
  $column_keys = array_map(function ($item) {
    return $item['Field'];
  }, $columns);
  // print_r($column_keys);
  $field_keys = array_map(function ($item) {
    return $item['name'];
  }, $fields);
  // print_r($field_keys);
  $insert_colmuns = [];
  $update_columns = [];
  foreach ($field_keys as $field_index => $field_key) {
    $sql = "";
    $index = array_search($field_key, $column_keys);
    $field = $fields[$field_index];
    if ($index === false) {
      array_push($insert_colmuns, $field_key);
      $sql .= "ALTER TABLE `{$export['table']}` ADD `{$field_key}` " . ($field['data_type'] ?? "text") . " NULL COMMENT '" . ($field['description'] ?? "") . "';\n";
    } else if ($columns[$index]['Type'] !== 'text') {
      $sql .= "ALTER TABLE `{$export['table']}` CHANGE `{$field_key}` `{$field_key}` " . ($field['data_type'] ?? "text") . " NULL COMMENT '" . ($field['description'] ?? "") . "';\n";
    }
    if ($sql !== "") {
      db::query($sql);
    }
  }
}




// $rows = db::select($tbname, ["collect_slug = '{$currentConfig['slug']}'", "collect_at IS NULL"], isset($commandConfig['test']) ? "LIMIT 1" : '');
// if (!empty($rows)) {
//   $currentConfig['scan_urls'] = array_merge($currentConfig['scan_urls'], array_map(function ($row) {
//     return $row['url'];
//   }, $rows ?? []));
// }
