<?php

namespace Illuminate\Environment;

class Environment extends \Core\Illuminate
{
  public $alias = 'env';
  private $env = [];
  function __construct()
  {
    // var_dump($GLOBALS);
    $_SERVER['System'] = php_uname();
    $this->env = $_ENV;
  }

  function get($name = null)
  {
    // var_dump(__METHOD__);
    if (empty($name)) {
      return $this->env;
    } else {
      if (array_key_exists($name, $this->env)) return $this->env[$name];
      else return;
    }
  }

  function is_mobile()
  {
    if (isset($this->env['HTTP_USER_AGENT'])) {
    }
  }
  function is_pc() {}
}
