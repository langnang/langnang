<?php

namespace Illuminate\Route;

use Closure;

class Route
{
  public $prefix;
  public $routes = [];

  use Traits\MagicMethods;
  use Traits\LifeCycleMethods;
  use Traits\AdjustMethods;

  function make() {}

  function match($methods, $uri, $func)
  {
    foreach ($methods as $method) {
      $method = strtoupper($method);
      if (!in_array($method, ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'])) continue;
      $uri = $this->adjust_uri($uri);
      if (!isset($this->routes[$uri['uri']])) $this->routes[$uri['uri']] = $uri;
      $this->routes[$uri['uri']][$method] = [
        "function" => $func
      ];
    }
    return $this;
  }
  function any($uri, $func)
  {
    $this->match(['get', 'post', 'put', 'patch', 'delete', 'options'], $uri, $func);
  }
  function get($uri, $func)
  {
    return $this->match([__FUNCTION__], $uri, $func);
  }
  function post($uri, $func)
  {
    return $this->match([__FUNCTION__], $uri, $func);
  }
  function put($uri, $func)
  {
    return $this->match([__FUNCTION__], $uri, $func);
  }
  function patch($uri, $func)
  {
    return $this->match([__FUNCTION__], $uri, $func);
  }
  // static function __callStatic($name, $arguments)
  // {
  //     var_dump(__METHOD__, $name, $arguments);
  // }

  function prefix($prefix)
  {
    $prefix = $this->adjust_uri($prefix);
    $this->prefix = rtrim($prefix['uri'], '/');
    return $this;
  }
  function group($callback)
  {
    $closure = Closure::bind($callback, $this);
    $closure();
    $this->prefix = null;
  }
}
