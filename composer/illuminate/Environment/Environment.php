<?php

namespace Illuminate\Environment;

class Environment extends \Core\Illuminate
{
  public $alias = 'env';
  public $_env = [];
  function __construct()
  {
    // var_dump($GLOBALS);
    $_SERVER['System'] = php_uname();
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
