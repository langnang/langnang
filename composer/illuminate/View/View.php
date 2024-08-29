<?php

namespace Illuminate\View;

class View
{
  public $alias = "view";

  function render($template)
  {
    echo $template;
  }

  function make($view, $data = [], $mergeData = [])
  {


    if (strpos($view, '::')) {
      // var_dump($view);
      $keys = explode("::", $view);
      $module = $keys[0];
      $view = $keys[1];
      $dir = implode("-", array_filter([\config($module . '.template'), \config($module . '.theme'), \config($module . '.layout')], function ($v) {
        return !empty($v);
      }));
      if (!empty($dir)) $dir .= '/';
      $file = __DIR__ . '/../../modules/' . config($module . '.name') . '/Views/' . $dir . $view . '.php';
    } else {
      $dir = implode("-", array_filter([\config('view.template'), \config('view.theme'), \config('view.layout')], function ($v) {
        return !empty($v);
      }));
      if (!empty($dir)) $dir .= '/';
      $file = __DIR__ . '/../../views/' . $dir . $view . '.php';
    }
    if (!file_exists($file)) throw new \Error("file $file not exists");
    $data = array_merge($data, $mergeData);
    foreach ($data as $key => $value) {
      $$key = $value;
    }
    // var_dump($file);
    require_once $file;
  }
}
