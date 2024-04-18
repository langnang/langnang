<?php

namespace Langnang\Typecho;

class TypechoController
{
  static function getDevConfig($prefix = NULL, $db = array())
  {
    $config = array_merge($GLOBALS["env_config"]["__cloud__"], $GLOBALS["env_config"]["typecho"]);
    if (!is_null($prefix)) {
      // 前缀为*，表示Typecho全库查询
      if ($prefix == '*') {
        $config["prefix"] = "*";
      } else {
        $prefix = "prefix_" . $prefix;
        if (isset($config[$prefix])) {
          $config["prefix"] = $config[$prefix];
        }
      }
    }

    return array_merge($config, $db);
  }
  /**
   * 创建数据表
   */
  static function crate()
  {
  }

  static function create_secondary($prefix, $mid, $_conn, $_db)
  {
    $sql = file_get_contents(__DIR__ . "/sqls/create_secondary_database.sql");
    $sql = str_replace("typecho_%_", "typecho_" . $prefix . "_", $sql);
    $sql = str_replace(":mid", $mid, $sql);
    $sql = str_replace(":user", $_db["user"], $sql);
    return $sql;
  }
  /**
   * 查询所有以Typecho前缀的数据表
   */
  static function tb_list()
  {
  }
  /**
   * 校验必须数据是否已存在
   * @param Object 被校验的对象
   * @param Array 数据格式
   */
  function is_required_set($object, $rules)
  {
    foreach ($rules as $param => $rule) {
      // 判断数据是否需要校验
      if (!isset($rule["required"]) || $rule["required"] != true) {
        continue;
      }
      // 空
      if (is_null($object->{$param})) {
        return "$param is null";
      }
    }
  }


  function insert_typecho_option()
  {
  }

  function delete_typecho_option()
  {
  }
}
