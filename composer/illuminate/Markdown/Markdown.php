<?php

namespace Illuminate\Markdown;

class Markdown
{
  public $aliases = [
    // 标题
    '/\n###### (.+)/' => '<h6 id="${1}"> ${1} </h6>',

    "/\n##### (.+)/" => '<h5 id="${1}"> ${1} </h5>',

    "/\n#### (.+)/" => '<h4 id="${1}"> ${1} </h4>',

    "/\n### (.+)/" => '<h3 id="${1}"> ${1} </h3>',

    "/\n## (.+)/" => '<h2 id="${1}"> ${1} </h2>',

    "/\n# (.+)/" => '<h1 id="${1}"> ${1} </h1>',
    // 引用
    "/\n> (.+)/" => '<blockquote> ${1} </blockquote>',
    // 代码块
    "/\n```(.+)/" => '<pre language="${1}">',

    "/\n```/" => '</pre>',
    // 链接
    "/\[(.+)\]\((.+)\)/" => '<a href="${2}"> ${1} </a>',
    // 图片
    "/!\[(.*)\]\((.+)\)/" => '<img src="${2}"> ${1} </img>',
    // 字体样式：加粗
    "/[*|_]{2,}(.+)[*|_]{2,}/" => '<b> ${1} </b>',
    // 字体样式：斜体
    "/[*|_](.+)[*|_]/" => '<i> ${1} </i>',
    // 表格
    // 列表
  ];

  function make($text, $options = [])
  {
    // dump([__METHOD__, $text, $options]);
    // dump([__METHOD__, $text, $options, $this->init_text($text), $this->split_text($text)]);
    // $arrays = $this->init_text(trim($text));
    // foreach ($arrays as $val) {
    $return = $this->to_html($this->init_text($text));
    // dump($return);
    // var_dump($return);
    // dump($return);
    // }
    return $return;
  }
  /**
   * 将原文中的水平制表符\t替换成空格,去除换行符\r:
   */
  function init_text($text)
  {
    $text = str_replace(array("\t", "\r"), array('', ''), $text);
    return $text;
  }

  function split_text($text)
  {
    $text = str_replace(array("\t", "\r"), array('', ''), $text);
    $text_arrays = explode("\n\n", $text);
    return $text_arrays;
  }
  function to_html($text)
  {
    $text = "\n" . $text;
    foreach ($this->aliases as $pattern => $subject) {
      // dump($args);
      if (preg_match($pattern, $text)) {
        $text = preg_replace($pattern, $subject, $text);
      }
    }
    return $text;
  }
}
