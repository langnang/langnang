<?php

namespace Illuminate\Module;

use Illuminate\Str\Facades\Str;

class Module
{
  public $_aliases = [];
  function _autoload()
  {
    // var_dump(config('modules.paths.modules'));
    // var_dump(resource_path());
    // var_dump(base_path('modules'));
    // var_dump(__METHOD__);
    foreach ((array)config('modules.paths.modules') as $path) {
      // var_dump($path);
      foreach (\glob($path . '/*', GLOB_ONLYDIR) as $module) {
        // var_dump($module);
        // config
        $filename = pathinfo($module)['filename'];
        // var_dump($filename);
        $config = require_once $module . '/Config/config.php';
        // var_dump($config);
        if (isset($config['alias'])) $alias = $config['alias'];
        else $alias = Str::snake($filename, '-');

        $config['name'] = $filename;
        $config['alias'] = $alias;
        // $config['module_path'];
        // var_dump($config);
        array_push($this->_aliases, $alias);
        \app('config')->set($alias, $config);

        // routes
        foreach (\glob($module . '/Routes/*.php') as $route) {
          // var_dump($route);
          require_once $route;
        }
      }
    }
  }
}
