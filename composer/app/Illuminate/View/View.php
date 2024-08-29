<?php

namespace App\Illuminate\View;

class View
{
  public $alias = "view";

  function render($template)
  {
    echo $template;
  }

  function make($view, $data = [], $mergeData = [])
  {
    $data = array_merge($data, $mergeData);
    foreach ($data as $key => $value) {
      $$key = $value;
    }

    $dir = implode("-", array_filter([\config('view.template'), \config('view.theme'), \config('view.layout')], function ($v) {
      return !empty($v);
    }));

    require_once __DIR__ . '/../../../views/' . $dir . '/' . $view . '.php';
  }
}
