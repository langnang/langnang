<?php

namespace Illuminate\Config;

/**
 * 配置项
 */

class Config
{
  public $aliases = [];

  use Traits\LifeCycleMethods;

  function get($key = null)
  {
    // var_dump(__METHOD__, $key);
    if (empty($key)) {
      return $this->aliases;
      // return array_reduce($this->aliases, function ($return, $alias) {
      //   $return[$alias] = $this->{$alias};
      //   return $return;
      // }, []);
    } else {
      return array_reduce(explode('.', $key), function ($return, $k) {
        if (empty($return)) return;
        if (!(array_key_exists($k, $return))) return;
        return $return[$k];
      }, $this->aliases);
    }
  }
  function set($key, $value = null)
  {
    if (empty($key)) return;

    $keys = explode('.', $key);

    if (sizeof($keys) == 1) {
      $this->aliases[$key] = $value;
    } else {
      $array = &$this->aliases[$keys[0]];
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
