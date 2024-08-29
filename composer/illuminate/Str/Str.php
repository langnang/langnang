<?php

namespace Illuminate\Str;

/**
 * 辅助函数：字符串
 */
class Str
{
  public $_str = '';
  /**
   * 判断指定字符串是否为给定值的结尾
   */
  function endsWith($value, $end)
  {
    return substr($value, -strlen($start)) == $end;
  }
  function lower($value)
  {
    return mb_strtolower($value, 'UTF-8');
  }
  /**
   * Markdown 转换为 HTML
   */
  function markdown($value)
  {
    var_dump(__METHOD__);
    return markdown_to_html($value);
  }
  /**
   * 将驼峰的函数名或者字符串转换成 _ 命名的函数或者字符串
   */
  function snake($value, $delimiter = "_")
  {
    return strtolower(preg_replace('/([a-z])([A-Z])/', '${1}' . $delimiter . '${2}', $value));
  }
  /**
   * 判断给定的字符串是否为给定值的开头
   */
  function startsWith($value, $start)
  {
    return substr($value, 0, strlen($start)) == $start;
  }
}
