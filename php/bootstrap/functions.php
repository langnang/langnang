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
if (!function_exists('env')) {
  function env($name = null)
  {
    return app(__FUNCTION__)->get($name);
  }
}
if (!function_exists('config')) {
  function config($name = null)
  {
    return app(__FUNCTION__)->get($name);
  }
}
