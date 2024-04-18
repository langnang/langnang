<?php

namespace Langnang;

use function GuzzleHttp\Psr7\str;

class lnString
{
  static function is_pc()
  {
  }
  static function is_mobile()
  {
  }
  /**
   * 检测运行环境是否为 Windows
   */
  static function is_window()
  {
    return substr(php_uname(), 0, 7) === "Windows";
  }
  /**
   * 检测运行环境是否为 Linux
   */
  static function is_linux()
  {
  }
  /**
　　* 下划线转驼峰
　　* 思路:
　　* step1.原字符串转小写,原字符串中的分隔符用空格替换,在字符串开头加上分隔符
　　* step2.将字符串中每个单词的首字母转换为大写,再去空格,去字符串首部附加的分隔符.
　　*/
  static function camelize($uncamelized_words, $separator = '_')
  {
    $uncamelized_words = $separator . str_replace($separator, " ", strtolower($uncamelized_words));
    return ltrim(str_replace(" ", "", ucwords($uncamelized_words)), $separator);
  }

  /**
   * 驼峰命名转下划线命名
　　* 思路:
　　* 小写和大写紧挨一起的地方,加上分隔符,然后全部转小写
　　*/
  static function uncamelize($camelCaps, $separator = '_')
  {
    return strtolower(preg_replace('/([a-z])([A-Z])/', "$1" . $separator . "$2", $camelCaps));
  }
  /**
   * 字符串转布尔值
   */
  static function to_bool($string)
  {
    return (bool)($string == 'true' || $string == '1' ? true : false);
  }
  static function to_int($string)
  {
    return (int)$string;
  }
  static function to_array($string)
  {
    $result = json_decode($string, JSON_UNESCAPED_UNICODE);
    if (is_null($result)) {
      if (substr($string, 0, 1) == '[') $string = substr($string, 1);
      if (substr($string, -1) == ']') $string = substr($string, 0, -1);
      $result = explode(",", $string);
    }
    return $result;
  }
}
