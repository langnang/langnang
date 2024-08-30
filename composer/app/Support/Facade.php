<?php

namespace App\Support;

class Facade
{
  public static $alias;
  function __call($name, $arguments)
  {
    var_dump(__METHOD__, $name, $arguments);
  }

  static function __callStatic($name, $arguments)
  {
    // var_dump(__METHOD__, $name);
    // global $app;
    $alias = static::$alias;
    if (empty($alias)) {
      // var_dump(static::class);
      $filename = pathinfo(static::class)['filename'];
      // var_dump($filename);
      // $alias = strtolower(preg_replace('/([a-z])([A-Z])/', '${1}_${2}', $filename));
      $alias = strtolower(preg_replace('/([a-z])([A-Z])/', '${1}-${2}', $filename));
      // throw new \Error(get_called_class() . " not set static \$alias.");
    }
    // var_dump($app, $alias);
    if (!method_exists(app($alias), $name)) {
      throw new \Error("$name not exists.");
    }
    return app($alias)->{$name}(...$arguments);
  }

  function __destruct()
  {
    var_dump(__METHOD__);
  }

  function __get($name)
  {
    var_dump(__METHOD__, $name);
  }

  function __set($name, $value)
  {
    var_dump(__METHOD__);
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

  function __toString()
  {
    var_dump(__METHOD__);
  }

  function __invoke()
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
