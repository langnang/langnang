<?php

namespace Illuminate\Config\Traits;

trait LifeCycleMethods
{
  function _() {}

  function _autoload(...$arguments)
  {
    if (empty(config('config'))) {
      $_config = require_once __DIR__ . '/../Config/config.php';
      $this->aliases['config'] = $_config;
    }
    foreach (config('config.paths.configs') as $path) {
      // var_dump($path);
      foreach (\glob($path . '/*/Config/config.php') as $file) {
        $filename = pathinfo(dirname(dirname($file)))['filename'];
        // var_dump($file);
        // var_dump($filename);
        $config = require_once $file;
        // var_dump($config);
        if ($config === true) continue;

        $alias = $config['alias'] ?? \Str::snake($filename, '-');
        // var_dump($alias);
        $this->aliases[$alias] = $config;
      }
    }
  }




  function _run()
  {
    // $this->router->run();
  }
}