<?php

namespace Illuminate\Route\Traits;

trait LifeCycleMethods
{
  function _run()
  {
    $uri = $this->adjust_uri($_SERVER['REQUEST_URI'] ?? "/");
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
        $controller = $func[0];
        if (\Str::startsWith($controller, '\\')) $controller = substr($controller, 1);
        // var_dump(config('controller.paths.aliases'));
        foreach (config('controller.paths.aliases') as $alias => $path) {
          if (\Str::startsWith($controller, $alias)) break;
        }
        // var_dump($alias);
        // var_dump($path);
        $controller = \Str::after($controller, $alias) . '.php';
        // var_dump($controller);
        foreach (\glob($path . DIRECTORY_SEPARATOR . '*.php') as $file) {
          if (\Str::endsWith($file, $controller)) break;
        }
        // var_dump($file);
        require_once $file;
        // $moduleAlias = array_slice(preg_split('/\\\|\//', $func[0]), 2, 1)[0];
        // var_dump($moduleAlias);

        // foreach (config('controller.paths.controllers') as $path) {
        //   var_dump($path);
        //   foreach (\glob($path . DIRECTORY_SEPARATOR . '*.php') as $file) {
        //     var_dump($file);
        //   }
        // }

        // foreach ((array)config('module.paths.modules') as $path) {
        //   // var_dump($path);
        //   foreach (\glob($path . '/*', GLOB_ONLYDIR) as $modulePath) {
        //     var_dump($modulePath);
        //     $filename = pathinfo($modulePath)['filename'];
        //     if ($filename == $moduleAlias) {
        //       // var_dump($path);
        //       // var_dump($module);
        //       // var_dump($filename);
        //       require_once $modulePath . '/Http/Controllers/' . pathinfo($func[0])['filename'] . '.php';
        //     }
        //   }
        // }

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
    foreach (config('route.paths.routes') as $path) {
      // var_dump($path);
      foreach (\glob($path . DIRECTORY_SEPARATOR . '*.php') as $file) {
        require_once $file;
      }
    }
  }
}
