<?php

namespace Illuminate\View;

class View
{
  function render($template)
  {
    echo $template;
  }

  function make($view, $data = [], $mergeData = [])
  {
    $alias = $this->alias;

    var_dump($alias);

    if (strpos($view, '::')) {
      // var_dump($view);
      $keys = explode("::", $view);
      $module = $keys[0];
      $view = $keys[1];
      $dir = implode("-", array_filter([\config($module . '.template'), \config($module . '.theme'), \config($module . '.layout')], function ($v) {
        return !empty($v);
      }));
      if (!empty($dir)) $dir .= '/';

      foreach ((array)config('modules.paths.modules') as $path) {
        var_dump($path);
        foreach (\glob($path . '/*', GLOB_ONLYDIR) as $modulePath) {
          var_dump($modulePath);
          $filename = pathinfo($modulePath)['filename'];
          if ($filename == config($module . '.name')) {
            // require_once $module . '/Http/Controllers/' . pathinfo($func[0])['filename'] . '.php';
            $file = $modulePath . '/Views/' . $dir . $view . '.php';
          }
        }
      }
    } else {
      $dir = implode("-", array_filter([\config('view.template'), \config('view.theme'), \config('view.layout')], function ($v) {
        return !empty($v);
      }));
      if (!empty($dir)) $dir .= '/';
      $file = __DIR__ . '/../../views/' . $dir . $view . '.php';
    }

    var_dump($file);
    if (!file_exists($file)) throw new \Error("file $file not exists");
    $data = array_merge($data, $mergeData);
    foreach ($data as $key => $value) {
      $$key = $value;
    }
    // var_dump($file);
    require_once $file;
  }
}
