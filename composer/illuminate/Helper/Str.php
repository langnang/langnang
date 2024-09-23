<?php

namespace Illuminate\Helper;

use Illuminate\Helper\Interfaces\StrInterface;
use Illuminate\Support\Stringable;
use Illuminate\ASCII\Facades\ASCII;

/**
 * 辅助函数：字符串
 */
class Str extends \Core\Illuminate implements Contracts\StrInterface
{
  /**
   * 返回字符串中指定值之后的所有内容。如果字符串中不存在这个值，它将返回整个字符串
   */
  function after($subject, $search)
  {
    return $search === '' ? $subject : array_reverse(explode($search, $subject, 2))[0];
  }
  /**
   * 将字符串转换为 ASCII 值
   */
  function ascii($value, $language = 'en')
  {
    // return ASCII::to_ascii((string) $value, $language);
  }
  function of($value)
  {
    return new Stringable($value);
  }
  /**
   * 判断指定字符串是否为给定值的结尾
   */
  function endsWith($value, $end)
  {
    return substr($value, -strlen($end)) == $end;
  }
  /**
   * 
   */
  function lower($value)
  {
    return mb_strtolower($value, 'UTF-8');
  }
  /**
   * Markdown 转换为 HTML
   */
  function markdown($value)
  {
    return markdown_to_html($value);
  }
  function slug($value, $delimiter = '-', $language = 'en')
  {
    $value = $language ? $this->ascii($value, $language) : $value;

    // Convert all dashes/underscores into delimiter
    $flip = $delimiter === '-' ? '_' : '-';

    $value = preg_replace('![' . preg_quote($flip) . ']+!u', $delimiter, $value);

    // Replace @ with the word 'at'
    $value = str_replace('@', $delimiter . 'at' . $delimiter, $value);

    // Remove all characters that are not the delimiter, letters, numbers, or whitespace.
    $value = preg_replace('![^' . preg_quote($delimiter) . '\pL\pN\s]+!u', '', $this->lower($value));

    // Replace all delimiter characters and whitespace by a single delimiter
    $value = preg_replace('![' . preg_quote($delimiter) . '\s]+!u', $delimiter, $value);

    return trim($value, $delimiter);
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
