<?php

namespace Illuminate\Str\Interfaces;

interface StrInterface
{
  function ascii($value, $language = 'en');
  /**
   * 判断指定字符串是否为给定值的结尾
   */
  function endsWith($value, $end);
  /**
   * Markdown 转换为 HTML
   */
  function markdown($value);
  /**
   * 将给定的字符串生成一个 URL 友好的「slug」
   */
  function slug($value, $delimiter = '-', $language = 'en');
  /**
   * 将驼峰的函数名或者字符串转换成 _ 命名的函数或者字符串
   */
  function snake($value, $delimiter = "_");
  /**
   * 判断给定的字符串是否为给定值的开头
   */
  function startsWith($value, $start);

  // function is();
  // function has();
  // function get();
  // function set();
  // function to();
  // function of();
  // function for();
  // function from();
  // function in();
  // function index();
  // function replace();
  // function split();
}
