<?php

namespace App;

class Application
{
  public $alias = "app";
  public $_aliases = [];
  function __construct()
  {
    // var_dump(__METHOD__);

    // load core modules
    foreach (\glob(__DIR__ . '/Illuminate/*', GLOB_ONLYDIR) as $file) {
      // var_dump($file);
      $filename = pathinfo($file)['filename'];
      // var_dump($filename);
      $className = "\App\Illuminate\\$filename\\$filename";

      $class = new $className;
      // var_dump($class);

      if (isset($class->alias)) $alias = $class->alias;
      else $alias = strtolower(preg_replace('/([a-z])([A-Z])/', '${1}_${2}', $filename));

      array_push($this->_aliases, $alias);

      $this->{$alias} = $class;
      // var_dump($class);
    }

    // var_dump($this->_aliases);
    // load helpers
    // foreach ($cfg['supports'] as $support) {
    // require_once $support;
    // }
  }
  function _autoload(...$arguments)
  {
    foreach ($this->_aliases as $alias) {
      if (method_exists($this->{$alias}, __FUNCTION__)) {
        $this->{$alias}->{__FUNCTION__}(...$arguments);
      }
    }
  }
  function singleton() {}
  function run()
  {
    // $this->router->run();
  }

  function __call($name, $arguments)
  {
    if (in_array($name, $this->_aliases)) {
      if (method_exists($this->{$name}, 'get')) {
        return $this->{$name}->{'get'}(...$arguments);
      }
    }
    var_dump(__METHOD__, $name, $arguments);
  }

  static function __callStatic($name, $arguments)
  {
    var_dump(__METHOD__, $name, $arguments);
  }

  function __destruct()
  {
    // var_dump(__METHOD__);
    $this->run();
  }

  function __get($name)
  {
    var_dump(__METHOD__, $name);
  }

  function __set($name, $value)
  {
    // var_dump(__METHOD__);
    $this->{$name} = $value;
  }

  function __isset($name)
  {
    var_dump(__METHOD__);
  }

  function __unset($name)
  {
    var_dump(__METHOD__);
  }

  function __sleep()
  {
    var_dump(__METHOD__);
  }

  function __wakeup()
  {
    var_dump(__METHOD__);
  }

  function __serialize()
  {
    var_dump(__METHOD__);
  }

  function __unserialize()
  {
    var_dump(__METHOD__);
  }

  function __toString()
  {
    var_dump(__METHOD__);
  }

  function __invoke()
  {
    var_dump(__METHOD__);
  }

  function __set_state()
  {
    var_dump(__METHOD__);
  }

  function __clone()
  {
    var_dump(__METHOD__);
  }

  function __debugInfo()
  {
    var_dump(__METHOD__);
  }
}
