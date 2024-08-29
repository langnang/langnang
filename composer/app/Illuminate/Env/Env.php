<?php

namespace App\Illuminate\Env;

class Env
{
  public $_env = [];
  function __construct()
  {
    $this->_env = parse_ini_file(__DIR__ . '/../../../.env');
  }

  function get($name = null)
  {
    // var_dump(__METHOD__);
    if (empty($name)) {
      return $this->_env;
    } else {
      if (array_key_exists($name, $this->_env)) return $this->_env[$name];
      else return;
    }
  }
}
