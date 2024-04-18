<?php

namespace Langnang\Typecho;

class TypechoModel
{
  // 数据库连接
  protected $conn;
  // 数据库配置
  protected $db;
  // 数据库名
  protected $dbname;
  // 数据表名
  protected $tbname;

  protected $suffix_tbname = "options";
  /**
   * 构造方法
   */
  function __construct($data, $conn = array(), $db = array("dbname" => "typecho", "prefix" => "typecho_"))
  {
    foreach ($data as $name => $value) {
      $this->__set($name, $value);
    }
    $this->setConn($conn);
    $this->setDb($db);
  }
  function __set($name, $value)
  {
    if (method_exists($this, 'set' . $name)) {
      $this->{'set' . $name}($value);
    } else if (!property_exists($this, $name)) {
      return;
    } else {
      $this->{$name} = $value;
    }
  }
  function __get($name)
  {
    if (!isset($this->{$name})) return;
    return $this->{$name};
  }
  function setConn($conn)
  {
    $this->conn = $conn;
  }
  function __sql($sql, $params = array())
  {
    $params["`:tbname`"] = "`$this->tbname`";
    $params["`:dbname`"] = "`$this->dbname`";
    foreach ($params as $key => $value) {
      $sql = str_replace($key, $value, $sql);
    }
    return $sql;
  }
  function setDb($db)
  {
    $this->db = $db;
    $this->setDbName($db["dbname"]);
    $this->setTbName($db["prefix"]);
  }
  function setDbName($dbname)
  {
    $this->dbname = $dbname;
  }
  function setTbName($prefix)
  {
    $this->tbname = $prefix . $this->suffix_tbname;
  }
}
