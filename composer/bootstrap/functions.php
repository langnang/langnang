<?php
function _e($str)
{
  echo $str;
}
if (!function_exists('app')) {
  function app($name = null)
  {
    global $app;
    if (empty($name)) return $app;
    return $app->{$name};
  }
}

foreach (\glob(__DIR__ . '/../app/Illuminate/*/functions.php') as $file) {
  require_once $file;
}
