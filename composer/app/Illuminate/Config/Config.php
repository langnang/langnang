<?php

namespace App\Illuminate\Config;

class Config
{
  public $_aliases = [];
  function __construct()
  {
    foreach (\glob(__DIR__ . '/../../../config/*.php') as $file) {
      // var_dump($file);
      $filename = pathinfo($file)['filename'];
      // var_dump($filename);
      $alias = strtolower(preg_replace('/([a-z])([A-Z])/', '${1}_${2}', $filename));

      array_push($this->_aliases, $alias);

      $this->{$alias} = require_once $file;
      // var_dump($this->{$alias});
      // $className = '\App\Illuminate\\' . $filename;

      // $class = new $className;

      // if (isset($class->alias)) $alias = $class->alias;
      // else $alias = strtolower(preg_replace('/([a-z])([A-Z])/', '${1}_${2}', $filename));

      // array_push($this->aliases, $alias);

      // $this->{$alias} = $class;
      // var_dump($class);
    }
  }
  function get($name = null)
  {
    if (empty($name)) {
      return array_reduce($this->_aliases, function ($return, $alias) {
        $return[$alias] = $this->{$alias};
        return $return;
      }, []);
    } else {
      return array_reduce(explode('.', $name), function ($return, $key) {
        if (empty($return)) return;
        if (!(array_key_exists($key, $return))) return;
        return $return[$key];
      }, (array)$this);
    }
  }
}
