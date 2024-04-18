<?php

namespace App\Helpers;

use Exception;

class ArrayHelper
{

  /**
   * 过滤处理数据
   */
  public static function filter($value, $program, $separator = "|")
  {
    return  array_reduce(explode($separator, $program), function ($value, $exp) {
      $funcExpArray = preg_split("/(\(|\)|,)/", $exp);
      $funcName = $funcExpArray[0];
      $last = array_pop($funcExpArray);
      if (function_exists($funcName)) {
        if (in_array($funcName, ['explode', 'date'])) {
          $value = call_user_func($funcName, $funcExpArray[1], $value, ...array_slice($funcExpArray, 2));
        } else {
          $value = call_user_func($funcName, $value, ...array_slice($funcExpArray, 1));
        }
      } else {
        throw new Exception("not exist function({$funcName}).");
        return;
      }
      if ($last && $last[0] == '[' && $last[strlen($last) - 1] == ']') {
        $key = substr($last, 1, -1);
        $value = $value[$key];
      }
      return $value;
    }, $value);
  }

  public static function array_find_index($array, $value, $key = null)
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
  /**
   * 列表数据转树状
   * @param array $array
   * @param string $child_key
   * @param string $parent_key
   * @param mixed $parent_value = null
   * @param int $depth = 1
   */
  public static function list_to_tree(array $array, string $child_key, string $parent_key, $parent_value = null, $depth = 1)
  {
    $array = json_decode(json_encode($array), JSON_UNESCAPED_UNICODE);
    if ($depth === 1) {
      foreach ($array as $item) {
        if (!is_null($item[$parent_key]) || $item[$parent_key] != 0) {
          if (self::array_find_index($array, $item[$parent_key], $child_key) == -1) {
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
        $item["children"] = self::list_to_tree($array, $child_key, $parent_key, $item[$child_key], 0);
        return $item;
      }, $children);
    }
  }
  /**
   * 树状数据转列表数据
   */
  public static function tree_to_list($tree = [], $children = 'children')
  {
    if (empty($tree) || !is_array($tree)) {
      return $tree;
    }
    $arrRes = [];
    foreach ($tree as $k => $v) {
      $arrTmp = $v;
      unset($arrTmp[$children]);
      $arrRes[] = $arrTmp;
      if (!empty($v[$children])) {
        $arrTmp = self::tree_to_list($v[$children]);
        $arrRes = array_merge($arrRes, $arrTmp);
      }
    }
    return $arrRes;
  }

  /**
   * 检测非零空值
   */
  public static function empty_not_zero($value)
  {
    return empty($value) && $value !== 0;
  }
}
