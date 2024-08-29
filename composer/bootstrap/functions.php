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

if (!function_exists('app_path')) {
  function app_path() {}
}
if (!function_exists('app_path')) {
  function base_path() {}
}
if (!function_exists('app_path')) {
  function config_path() {}
}
if (!function_exists('app_path')) {
  function database_path() {}
}
if (!function_exists('app_path')) {
  function lang_path() {}
}
if (!function_exists('app_path')) {
  function mix() {}
}
if (!function_exists('app_path')) {
  function public_path() {}
}
if (!function_exists('app_path')) {
  function resource_path() {}
}
if (!function_exists('app_path')) {
  function storage_path() {}
}
foreach (\glob(__DIR__ . '/../illuminate/*/functions.php') as $file) {
  require_once $file;
}
