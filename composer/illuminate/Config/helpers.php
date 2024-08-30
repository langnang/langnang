<?php

if (!function_exists('config')) {
  function config($name = null)
  {
    return app(__METHOD__)->get($name);
  }
}
