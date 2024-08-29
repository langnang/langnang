<?php

namespace Illuminate\Application;

class Application
{
  public $alias = "app";
  public $_aliases = [];
  function __construct($basePath = null)
  {
    // var_dump(__FILE__);
    // var_dump(__CLASS__);
    if ($basePath) {
      $this->setBasePath($basePath);
    }
    // load core modules
    foreach (\glob(__DIR__ . '/../*', GLOB_ONLYDIR) as $file) {
      $filename = pathinfo($file)['filename'];
      // var_dump($filename);
      $className = "\Illuminate\\$filename\\$filename";
      if ($className == '\\' . __CLASS__) continue;

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
  function path($path = '')
  {
    $appPath = $this->appPath ?: $this->basePath . DIRECTORY_SEPARATOR . 'app';

    return $appPath . ($path ? DIRECTORY_SEPARATOR . $path : $path);
  }
  function setBasePath($basePath)
  {
    $this->basePath = rtrim($basePath, '\/');
    return $this;
  }
  function resourcePath($path = '')
  {
    return $this->basePath . DIRECTORY_SEPARATOR . 'resources' . ($path ? DIRECTORY_SEPARATOR . $path : $path);
  }
  function basePath($path = '')
  {
    return $this->basePath . ($path ? DIRECTORY_SEPARATOR . $path : $path);
  }

  function databasePath($path = '')
  {
    return ($this->databasePath ?: $this->basePath . DIRECTORY_SEPARATOR . 'database') . ($path ? DIRECTORY_SEPARATOR . $path : $path);
  }
  function publicPath()
  {
    return $this->basePath . DIRECTORY_SEPARATOR . 'public';
  }
  function langPath()
  {
    if ($this->langPath) {
      return $this->langPath;
    }

    if (is_dir($path = $this->resourcePath() . DIRECTORY_SEPARATOR . 'lang')) {
      return $path;
    }

    return $this->basePath() . DIRECTORY_SEPARATOR . 'lang';
  }
  function configPath($path = '')
  {
    return $this->basePath . DIRECTORY_SEPARATOR . 'config' . ($path ? DIRECTORY_SEPARATOR . $path : $path);
  }

  function singleton() {}
  function run()
  {
    // $this->router->run();
  }

  function __call($name, $arguments)
  {
    if (method_exists($this, $name)) {
      return $this->{$name}(...$arguments);
    }
    if (in_array($name, $this->_aliases)) {
      if (method_exists($this->{$name}, 'get')) {
        return $this->{$name}->{'get'}(...$arguments);
      }
    }
    // var_dump(__METHOD__, $name, $arguments);
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
