<?php

namespace App\Illuminate;

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
    require_once __DIR__ . '/../../views/' . \config('view.template') . '/' . \config('view.theme') . '/' . $view . '.php';
  }
}
