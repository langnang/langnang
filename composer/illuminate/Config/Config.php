<?php

namespace Illuminate\Config;

class Config
{
  public $_aliases = [];
  function __construct()
  {
    foreach (\glob(__DIR__ . '/../../config/*.php') as $file) {
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
  function get($key = null)
  {
    if (empty($key)) {
      return array_reduce($this->_aliases, function ($return, $alias) {
        $return[$alias] = $this->{$alias};
        return $return;
      }, []);
    } else {
      return array_reduce(explode('.', $key), function ($return, $k) {
        if (empty($return)) return;
        if (!(array_key_exists($k, $return))) return;
        return $return[$k];
      }, (array)$this);
    }
  }
  function set($key, $value = null)
  {
    if (empty($key)) return;

    $keys = explode('.', $key);



    if (sizeof($keys) == 1) {
      $this->{$key} = $value;
    } else {
      $array = &$this->{$keys[0]};
      $keys = array_slice($keys, 1);
      foreach ($keys as $i => $key) {
        if (count($keys) === 1) {
          break;
        }
        unset($keys[$i]);

        if (!isset($array[$key]) || ! is_array($array[$key])) {
          $array[$key] = [];
        }

        $array = &$array[$key];
      }

      $array[array_shift($keys)] = $value;
    }
    return $this;
  }
}
