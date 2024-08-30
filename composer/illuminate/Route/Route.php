<?php

namespace Illuminate\Route;

use Closure;
use Illuminate\Route\Abstracts\AdjustUri;
use Illuminate\Str\Facades\Str;

class Route
{
  public $_prefix;
  public $_routes = [];

  use Traits\MagicMethods;
  use Traits\LifeCycleMethods;
  use Traits\AdjustMethods;

  function match($methods, $uri, $func)
  {
    foreach ($methods as $method) {
      $method = strtolower($method);
      if (!method_exists($this, $method)) continue;
      $this->{$method}($uri, $func);
    }
  }
  function any($uri, $func)
  {
    $this->match(['get', 'post', 'put', 'patch', 'delete', 'options'], $uri, $func);
  }
  function get($uri, $func)
  {
    $uri = $this->adjust_uri($uri);
    if (!isset($this->_routes[$uri])) $this->_routes[$uri] = [];
    $this->_routes[$uri]['GET'] = $func;
  }
  function post($uri, $func)
  {
    $uri = $this->adjust_uri($uri);
    if (!isset($this->_routes[$uri])) $this->_routes[$uri] = [];
    $this->_routes[$uri]['POST'] = $func;
  }
  function put($uri, $func)
  {
    $uri = $this->adjust_uri($uri);
    if (!isset($this->_routes[$uri])) $this->_routes[$uri] = [];
    $this->_routes[$uri]['PUT'] = $func;
  }
  function patch($uri, $func)
  {
    $uri = $this->adjust_uri($uri);
    if (!isset($this->_routes[$uri])) $this->_routes[$uri] = [];
    $this->_routes[$uri]['patch'] = $func;
  }
  // static function __callStatic($name, $arguments)
  // {
  //     var_dump(__METHOD__, $name, $arguments);
  // }

  function prefix($prefix)
  {
    $prefix = $this->adjust_uri($prefix);
    $this->_prefix = rtrim($prefix, '/');
    return $this;
  }
  function group($callback)
  {
    $closure = Closure::bind($callback, $this);
    $closure();
    $this->_prefix = null;
  }
}
