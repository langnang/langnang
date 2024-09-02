<?php

namespace Illuminate\Application\Traits;

trait MagicMethods
{
  function __construct($basePath = null)
  {
    // var_dump(__FILE__);
    // var_dump(__CLASS__);
    if ($basePath) {
      $this->setBasePath($basePath);
    }
    // load core modules
    foreach (\glob(__DIR__ . DIRECTORY_SEPARATOR . '../../*', GLOB_ONLYDIR) as $file) {
      $filename = pathinfo($file)['filename'];

      if (in_array($filename, $_ENV['ILLUMINATE_IGNORES'])) continue;

      // var_dump($filename);
      $className = "Illuminate\\$filename\\$filename";

      \class_alias("Illuminate\\$filename\Facades\\$filename", $filename);

      if ($className == __CLASS__) continue;

      $class = new $className;
      // var_dump($class);

      if (isset($class->alias)) $alias = $class->alias;
      else $alias = strtolower(preg_replace('/([a-z])([A-Z])/', '${1}-${2}', $filename));

      $class->name = $filename;
      $class->alias = $alias;

      $this->aliases[$alias] = $class;

      // array_push($this->_aliases, $alias);

      // $this->{$alias} = $class;
      // var_dump($class);
    }

    // var_dump($this->_aliases);
    // load helpers
    // foreach ($cfg['supports'] as $support) {
    // require_once $support;
    // }
  }

  function __call($name, $arguments)
  {
    if (method_exists($this, $name)) {
      return $this->{$name}(...$arguments);
    }
    if (isset($this->aliases[$name])) {
      $illuminate = $this->aliases[$name];
      if (method_exists($illuminate, 'get')) {
        return $illuminate->{'get'}(...$arguments);
      }
    }
  }

  static function __callStatic($name, $arguments)
  {
    var_dump(__METHOD__, $name, $arguments);
  }

  function __get($name)
  {
    // var_dump(__METHOD__, $name);
    // return $this->{$name};
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
    // var_dump(__METHOD__);
  }
}
