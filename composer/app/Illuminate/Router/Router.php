<?php

namespace App\Illuminate\Router;

use Closure;

class Router
{
  public $alias = "router";
  public $_prefix;
  public $_routes = [];
  function run()
  {
    $uri = $_SERVER['PATH_INFO'];
    $method = $_SERVER['REQUEST_METHOD'];
    if (array_key_exists($uri, $this->_routes) && array_key_exists($method, $this->_routes[$uri])) {
      $func = $this->_routes[$uri][$method];
    } else if (array_key_exists("*", $this->_routes)) {
      $func = $this->_routes["*"][$method];
    } else {
      $func = function () {};
    }


    $func(app('request'));
    // var_dump($_SERVER);
    // $method();
    // $method = $_SERVER['REQUEST_METHOD'];
  }
  function _init() {}
  function _autoload()
  {
    require_once __DIR__ . '/../../../routes/api.php';
    require_once __DIR__ . '/../../../routes/web.php';
  }
  function match($methods, $uri, $func) {}
  function any($uri, $func)
  {
    $this->get($uri, $func);
    $this->post($uri, $func);
  }
  function get($uri, $func)
  {
    if (!empty($this->_prefix)) $uri = $this->_prefix . '/' . $uri;
    if (!isset($this->_routes[$uri])) $this->_routes[$uri] = [];
    $this->_routes[$uri]['GET'] = $func;
  }
  function post($uri, $func)
  {
    if (!empty($this->_prefix)) $uri = $this->_prefix . '/' . $uri;
    if (!isset($this->_routes[$uri])) $this->_routes[$uri] = [];
    $this->_routes[$uri]['POST'] = $func;
  }
  function put($uri, $func)
  {
    if (!empty($this->_prefix)) $uri = $this->_prefix . '/' . $uri;
    if (!isset($this->_routes[$uri])) $this->_routes[$uri] = [];
    $this->_routes[$uri]['PUT'] = $func;
  }
  function patch($uri, $func)
  {
    if (!empty($this->_prefix)) $uri = $this->_prefix . '/' . $uri;
    if (!isset($this->_routes[$uri])) $this->_routes[$uri] = [];
    $this->_routes[$uri]['patch'] = $func;
  }
  // static function __callStatic($name, $arguments)
  // {
  //     var_dump(__METHOD__, $name, $arguments);
  // }

  function prefix($prefix)
  {
    $this->_prefix = $prefix;
    return $this;
  }
  function group($callback)
  {
    $closure = Closure::bind($callback, $this);
    $closure();
    $this->_prefix = null;
  }

  function __set($name, $value)
  {
    $this->{$name} = $value;
  }

  function __destruct()
  {
    // var_dump(__METHOD__);
    $this->run();
  }
}
