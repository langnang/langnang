<?php
if (!function_exists('http')) {
  function http($name = null)
  {
    return app(__FUNCTION__);
  }
}
