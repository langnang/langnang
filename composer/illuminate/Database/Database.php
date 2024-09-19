<?php

namespace Illuminate\Database;

class Database extends \Core\Illuminate
{

  private $connection;
  private $drivers = [];
  private $config = [];
  function _autoload()
  {
    // dump(__METHOD__);
    $this->config = $config = config('database.connections.' . config('database.default'));
    // dump($config);
    // $this->db = new DB($config);
    // dump($this);
  }

  function _run() {}
}
