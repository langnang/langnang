<?php

$_SQL[pathinfo(__DIR__)['filename']][pathinfo(__FILE__)['filename']] = [
  "select_table_list" => function ($conn) {
    return "SELECT * FROM `INFORMATION_SCHEMA`.`TABLES` 
    WHERE `TABLE_SCHEMA` = '{$conn->getParams()['dbname']}'
      AND `TABLE_TYPE` = 'BASE TABLE'
    ;";
  },
  "select_table_info" => function ($conn) {
    return "SELECT * FROM `INFORMATION_SCHEMA`.`TABLES` 
      WHERE `TABLE_SCHEMA` = '{$conn->getParams()['dbname']}'
        AND `TABLE_NAME` = '{$_GET['table_name']}'
    ;";
  },
  "select_table_count" => function ($conn) {
    global $_SQL;
    $_self = $_SQL[pathinfo(__DIR__)['filename']][pathinfo(__FILE__)['filename']];
    return $_SQL['$']['select_count']($_self['select_table_list']($conn));
  },
  "select_column_list" => function ($conn) {
    return "SELECT * FROM `INFORMATION_SCHEMA`.`COLUMNS` 
    WHERE `TABLE_SCHEMA` = '{$conn->getParams()['dbname']}'
      AND `TABLE_NAME` = '{$_GET['table_name']}'
    ;";
  },
  "select_column_info" => function ($conn) {
    return "SELECT * FROM `INFORMATION_SCHEMA`.`COLUMNS` 
    WHERE `TABLE_SCHEMA` = '{$conn->getParams()['dbname']}'
      AND `TABLE_NAME` = '{$_GET['table_name']}'
      AND `COLUMN_NAME` = '{$_GET['column_name']}'
    ;";
  },
  "select_column_count" => function ($conn) {
    global $_SQL;
    $_self = $_SQL[pathinfo(__DIR__)['filename']][pathinfo(__FILE__)['filename']];
    return $_SQL['$']['select_count']($_self['select_column_list']($conn));
  },
];
