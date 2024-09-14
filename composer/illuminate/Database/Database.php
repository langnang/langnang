<?php

namespace Illuminate\Database;

class Database
{
  public $db;
  function _autoload()
  {
    // dump(__METHOD__);
    $config = config('database.connections.' . config('database.default'));
    // dump($config);
    $this->db = new DB($config);
  }

  function _run() {}
}
