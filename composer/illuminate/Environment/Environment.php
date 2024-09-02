<?php

namespace Illuminate\Environment;

class Environment
{
  public $alias = 'env';
  public $_env = [];
  function __construct()
  {
    $this->_env = $_ENV;
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
