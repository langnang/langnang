<?php

namespace Illuminate\Database\Drivers;

class MySqliDriver
{
  public $alias = "mysqli";
  public $con;
  function connection()
  {
    $config = app('database')->get_config();
    $this->con = mysqli_connect($config['host'], $config['username'], $config['password'], $config['database'], $config['port'] ?: 3306);
    return $this;
  }
  function insert(...$values) {}
  function select(...$values)
  {
    dump(__METHOD__, $values);
  }
  function table($tbname)
  {
    return $this;
  }
  function exists() {}
}
