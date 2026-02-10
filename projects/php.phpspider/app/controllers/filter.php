<?php

namespace app\controllers;

class filter
{
  /**
   * 根据配置过滤处理字段数据
   *
   * @param mixed $values
   * @param mixed $filter
   * @return void
   */
  public function filter_field($values, $filters)
  {
    $filters = explode('|', $filters);
    foreach ($filters as $filter) {
      // 开始标签
      $startTag = strpos($filter, "(");
      // 结束标签
      $endTag = strripos($filter, ")");

      $latestStr = substr($filter, $endTag + 1);
      // 函数
      $func = $startTag == false ? $filter : substr($filter, 0, $startTag);
      // 参数
      $argStr = substr($filter, $startTag + 1, $endTag - $startTag - 1);
      $args = preg_split('/,/', $argStr);

      $isValid = true;
      // 参数数组长度大于0
      if (count($args) > 0) {
        foreach ($args as $arg) {
          if (!$this->isValid($arg)) {
            $isValid = false;
            break;
          }
        }
      }

      if (!$isValid)
        $args = array($argStr);
      // var_dump($args);

      // 判断分隔符前是否有匹配对应的括号
      $splitTag = strpos($argStr, ",");

      foreach ($args as $index => $arg) {
        $startTag = strpos($arg, "(");
        $endTag = strripos($arg, ")");
        if ($startTag !== false && $endTag !== false) {
          $args[$index] = $this->filter_field($values, $arg);
        }
      }
      // $splits = preg_split("/\(|,|\)/", $filter);
      // 去除最后一个空元素
      // var_dump($splits);
      // exit();
      if ($args[count($args) - 1] == "") {
        $args = array_slice($args, 0, -1);
      }
      // $func = $splits[0];
      // $args = array_slice($splits, 1);
      // 获取数组中指定参数的值
      $keys = [];
      if (strpos($latestStr, ".") === 0) {
        $keys = preg_split("/\./", $latestStr);
        // 去除第一个空白元素
        $keys = array_slice($keys, 1);
        if ($keys[count($keys) - 1] == "") {
          $keys = array_slice($keys, 0, -1);
        }
        // $args = array_slice($args, -1);
      }
      if (function_exists($func)) {
        if (in_array($func, ['array_search'])) {
          $values = call_user_func($func, $args[0], $values, ...array_slice($args, 1));
        } else {
          // 第一个参数是变量
          $values = call_user_func($func, $values, ...$args);
        }
      } else if (method_exists($this, $func)) {
        $values = $this->{$func}($values, ...$args);
        // $values = call_user_method ($func, $this, $values, ...$args);
        // $values = call_user_func($func, $values, ...$args);
      } else if (is_array($values) && isset($values[$func])) {
        // 获取数组的参数值
        $values = $values[$func];
      } else {
        // var_dump($func);
        // var_dump($values);
      }
      if (count($keys) > 0) {
        $values = array_reduce($keys, function ($total, $key) {
          return isset($total[$key]) ? $total[$key] : null;
        }, $values);
      }
    }
    return $values;
  }
}
