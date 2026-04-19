<?php

// 读取配置信息
function _get($name)
{
  global $config;
  $keys = explode("_", $name);
  foreach ($keys as $i => $value) :
    $i == 0 ? ($keys[$i] .= "_config") : NULL;
  endforeach;
  return array_reduce($keys, function ($array, $key) {
    return $array[$key];
  }, $config);
}
