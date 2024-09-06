<?php

namespace Illuminate\Router\Traits;

trait LifeCycleMethods
{
  /**
   * 
   */
  function _run()
  {
    $_uri = $this->adjust_uri($_SERVER['REQUEST_URI'] ?? "/");

    $uri = strtolower($_uri['uri']);

    // dump($_SERVER);
    // dump($uri);
    $method = $_SERVER['REQUEST_METHOD'];

    app_log(__METHOD__ . " " . json_encode($_uri));

    // dump([$uri, $method, preg_match("/{(.+)}/", $uri, $match)]);
    // dump($this->routes);
    // dump([$uri, preg_match('/^\/manual\/(\\w+)$/', $uri)]);
    // $func = '';
    if (isset($this->routes[$uri]) && isset($this->routes[$uri][$method])) {
      // $func = $route[$method]['function'];
      $route = $this->routes[$uri][$method];
    }
    // dump($route);
    if (empty($route)) {
      foreach ($this->routes as $route) {
        // 匹配请求方法
        if (!array_key_exists($method, $route)) continue;
        // 精准匹配
        if ($route['uri'] === $uri) {
          $route = $route[$method];
          // 模糊匹配
        } else if (!empty($route['pattern'])) {
          // dump('/^' . htmlspecialchars($route['pattern']) . '$/');
          // dump($pattern = $route['pattern']);
          $pattern = '/^' . str_replace('/', '\/', $route['pattern']) . '$/';
          if (preg_match($pattern, $uri, $params)) {
            $route = $route[$method];
            $route['args'] = array_slice($params, 1,);
            // dump($route);
            break;
          }
          // dump($pattern = preg_quote($pattern));
          // dump($pattern = str_replace('/', '\/', $pattern));
          // dump(preg_match_all('/^' . $pattern . '$/', $uri,));
          // dump(str_replace('/', '\/', preg_quote($route['pattern'])), preg_match_all('/^' . preg_quote($route['pattern']) . '$/', $uri,));
          // dump($route['pattern'], preg_match_all(htmlspecialchars($route['pattern']), $uri,));
          // if (preg_match_all($route['pattern'], $uri, $args)) {
          // dump($args);
          // }
        }
        unset($route);
      }
    }
    // dump($route);
    unset($pattern);
    // 未匹配到路由
    if (empty($route)) {
      if (array_key_exists("/*", $this->routes)) {
        $route = $this->routes["/*"][$method];
      }
    } else {
      app_log(__METHOD__ . " " . json_encode($route));
    }
    if (empty($route)) {
      $route = [
        'function' => function () {}
      ];
    }
    $func = $route['function'];

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
        return (new $func[0])->{$func[1]}(app('request'), ...$route['args'] ?? []);
      }
    }

    return $func(app('request'), ...$route['args'] ?? []);
    // var_dump($_SERVER);
    // $method();
    // $method = $_SERVER['REQUEST_METHOD'];
  }

  function _init() {}
  function _autoload()
  {
    foreach (config('router.paths.routes') as $path) {
      // var_dump($path);
      foreach (\glob($path . DIRECTORY_SEPARATOR . '*.php') as $file) {
        require_once $file;
      }
    }
  }
}
