<?php

if (!function_exists('env')) {
  function env($name = null)
  {
    return app(__FUNCTION__)->get($name);
  }
}
