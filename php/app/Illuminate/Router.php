<?php

namespace App\Illuminate;

class Router
{
  public $alias = "router";
  public $maps = [];
  public $routes = [];
  function run()
  {
    // var_dump($_SERVER);
    // var_dump($this->routes);
    $func = $this->routes[$_SERVER['PATH_INFO']][$_SERVER['REQUEST_METHOD']];

    $func($this);
    // $method();
    // $method = $_SERVER['REQUEST_METHOD'];
  }
  function __autoload()
  {
    global $app;
    require_once __DIR__ . '/../../routes/api.php';
    require_once __DIR__ . '/../../routes/web.php';
  }
  function group() {}
  function match($methods, $uri, $func) {}
  function any($uri, $func)
  {
    $this->get($uri, $func);
    $this->post($uri, $func);
  }
  function get($uri, $func)
  {
    if (!isset($this->routes[$uri])) $this->routes[$uri] = [];
    $this->routes[$uri]['GET'] = $func;
  }
  function post($uri, $func)
  {
    if (!isset($this->routes[$uri])) $this->routes[$uri] = [];
    $this->routes[$uri]['POST'] = $func;
  }
  function put($uri, $func)
  {
    if (!isset($this->routes[$uri])) $this->routes[$uri] = [];
    $this->routes[$uri]['PUT'] = $func;
  }
  function patch($uri, $func)
  {
    if (!isset($this->routes[$uri])) $this->routes[$uri] = [];
    $this->routes[$uri]['patch'] = $func;
  }
  // static function __callStatic($name, $arguments)
  // {
  //     var_dump(__METHOD__, $name, $arguments);
  // }
  function __call($name, $arguments)
  {
    var_dump(__METHOD__, $name, $arguments);
  }

  static function __callStatic($name, $arguments)
  {
    var_dump(__METHOD__, $name, $arguments);
  }

  function __destruct()
  {
    // var_dump(__METHOD__);
    $this->run();
  }

  function __get($name)
  {
    var_dump(__METHOD__, $name);
  }

  function __set($name, $value)
  {
    var_dump(__METHOD__);
    $this->{$name} = $value;
  }

  function __isset($name)
  {
    var_dump(__METHOD__);
  }

  function __unset($name)
  {
    var_dump(__METHOD__);
  }

  function __sleep()
  {
    var_dump(__METHOD__);
  }

  function __wakeup()
  {
    var_dump(__METHOD__);
  }

  function __serialize()
  {
    var_dump(__METHOD__);
  }

  function __unserialize()
  {
    var_dump(__METHOD__);
  }

  function __toString()
  {
    var_dump(__METHOD__);
  }

  function __invoke()
  {
    var_dump(__METHOD__);
  }

  function __set_state()
  {
    var_dump(__METHOD__);
  }

  function __clone()
  {
    var_dump(__METHOD__);
  }

  function __debugInfo()
  {
    var_dump(__METHOD__);
  }
}
