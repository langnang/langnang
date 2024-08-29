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
  function endsWith($str, $end)
  {
    return substr($str, -strlen($start)) == $end;
  }
  /**
   * Markdown 转换为 HTML
   */
  function markdown()
  {
    var_dump(__METHOD__);
  }
  /**
   * 判断给定的字符串是否为给定值的开头
   */
  function startsWith($str, $start)
  {
    return substr($str, 0, strlen($start)) == $start;
  }
}
