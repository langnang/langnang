<?php

namespace Illuminate\Route\Traits;


/**
 * 矫正URI
 */
trait AdjustMethods
{
  /**
   * 以`/`开头，不以`/`结尾
   */
  function adjust_uri($uri)
  {
    // 替换全部空格
    $uri = preg_replace('/ /', '', $uri);

    $uri = rtrim($uri, '/');
    // if (Str::endsWith($uri, '/')) $uri = substr($uri, 0, -1);

    if (!\Str::startsWith($uri, "/")) $uri = '/' . $uri;

    if (!empty($this->_prefix)) {
      $uri = $this->_prefix .  $uri;
      $uri = rtrim($uri, '/');
    }

    return $uri;
  }
}