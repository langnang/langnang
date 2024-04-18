<?php

namespace Langnang\Component\ArrayAccess;

class ArrayController
{
  function is($object)
  {
    return is_array($object);
  }
  /**
   * 检测指定键是否存在
   */
  function key_exists($array, $key)
  {
    return array_key_exists($key, $array);
  }
  function is_set()
  {
  }
  function is_exists()
  {
  }
  /**
   * 查找
   * @param Array $array
   * @param * $array
   * @param String $array 如果值为数组的条件下对应的键
   */
  static function index($array, $value, $key = null)
  {
    if (sizeof($array) == 0) return -1;
    foreach ($array as $_key => $_value) {
      if (is_null($key)) {
        if ($_value == $value) {
          return $_key;
        }
      } else {
        if ($_value[$key] == $value) {
          return $_key;
        }
      }
    }
    return -1;
  }
  static function is_includes()
  {
  }
  /**
   * 列表转换为树
   * @param Array array 需要转换的列表
   * @param String child_key 字节中存储唯一识别码的的键
   * @param String parent_key 字节中存储对应父字节关键字的键
   * @param String parent_value 字节中存储对应父字节关键字的值
   */
  static function to_tree($array, $child_key, $parent_key, $parent_value = null, $depth = 1)
  {
    if ($depth === 1) {
      foreach ($array as $item) {
        if (!is_null($item[$parent_key]) || $item[$parent_key] != 0) {
          if (self::index($array, $item[$parent_key], $child_key) == -1) {
            array_push($array, array(
              $child_key => $item[$parent_key],
              $parent_key => $parent_value
            ));
          }
        }
      }
    }
    $children = [];
    foreach ($array as $item) {
      if ($item[$parent_key] === $parent_value && $item[$child_key] !== $parent_value) {
        array_push($children, $item);
      }
    }
    if (sizeof($children) == 0) {
      return $children;
    } else {
      return array_map(function ($item) use ($array, $child_key, $parent_key) {
        $item["children"] = self::to_tree($array, $child_key, $parent_key, $item[$child_key], 0);
        return $item;
      }, $children);
    }
  }
}
