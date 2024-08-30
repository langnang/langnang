<?php

namespace Illuminate\Route;

use Closure;
use Illuminate\Route\Abstracts\AdjustUri;
use Illuminate\Str\Facades\Str;

class Route extends AdjustUri
{
  public $_prefix;
  public $_routes = [];
  function run()
  {
    $uri = $this->adjust_uri($_SERVER['PATH_INFO']);
    $method = $_SERVER['REQUEST_METHOD'];
    if (array_key_exists($uri, $this->_routes) && array_key_exists($method, $this->_routes[$uri])) {
      $func = $this->_routes[$uri][$method];
    } else if (array_key_exists("/*", $this->_routes)) {
      $func = $this->_routes["/*"][$method];
    } else {
      $func = function () {};
    }

    if (is_string($func)) $func = explode("@", $func);

    if (is_array($func)) {
      if (sizeof($func) == 0) {
        throw new \Error("Error route $uri callback");
      } else {
        $moduleAlias = array_slice(preg_split('/\\\|\//', $func[0]), 2, 1)[0];
        foreach ((array)config('modules.paths.modules') as $path) {
          foreach (\glob($path . '/*', GLOB_ONLYDIR) as $modulePath) {
            $filename = pathinfo($modulePath)['filename'];
            if ($filename == $moduleAlias) {
              // var_dump($path);
              // var_dump($module);
              // var_dump($filename);
              require_once $modulePath . '/Http/Controllers/' . pathinfo($func[0])['filename'] . '.php';
            }
          }
        }

        // require_once __DIR__ . '/../../' . strtolower(substr($func[0], 1, 1)) . str_replace("\\", '/', substr($func[0], 2))  . '.php';
        return (new $func[0])->{$func[1]}(app('request'));
      }
    }

    return $func(app('request'));
    // var_dump($_SERVER);
    // $method();
    // $method = $_SERVER['REQUEST_METHOD'];
  }
  function _init() {}
  function _autoload()
  {
    require_once __DIR__ . '/../../routes/api.php';
    require_once __DIR__ . '/../../routes/web.php';
  }
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
