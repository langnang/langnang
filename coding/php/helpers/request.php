<?php


class request
{
  static function get() {}
  static function post() {}
}

if (!function_exists('request')) {
  function request($opts = [])
  {
    var_dump('request');
    var_dump($opts);
  }
}
if (!function_exists('request_get')) {
  function request_get($url, $opts = [])
  {
    $headers = [
      'Content-Type' => 'application/json'
    ];
    $ch = curl_init();
    $timeout = 60;
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
    // 设置 HTTP 头部，包括 Authorization
    if (array_key_exists('headers', $opts)) {
      curl_setopt($ch, CURLOPT_HTTPHEADER, $opts['headers']);
    }
    $return = curl_exec($ch);
    if ($return === false) {
      echo 'Curl error: ' . curl_error($ch);
    }
    curl_close($ch);

    return $return;
  }
}
if (!function_exists('request_post')) {
  function request_post($url, $opts)
  {
    $headers = [
      'Content-Type' => 'application/json'
    ];
    $ch = curl_init();
    $timeout = 5;
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    // 设置 HTTP 头部，包括 Authorization
    if (array_key_exists('headers', $opts)) {
      curl_setopt($ch, CURLOPT_HTTPHEADER, $opts['headers']);
    }
    $return = curl_exec($ch);
    curl_close($ch);

    return $return;
  }
}
if (!function_exists('request_put')) {
  function request_put($opts) {}
}
if (!function_exists('request_delete')) {
  function request_delete($opts) {}
}
if (!function_exists('request_patch')) {
  function request_patch($opts) {}
}
if (!function_exists('request_head')) {
  function request_head($opts) {}
}
if (!function_exists('request_options')) {
  function request_options($opts) {}
}
