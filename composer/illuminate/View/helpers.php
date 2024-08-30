<?php

if (!function_exists('view')) {
  function view(...$arguments)
  {
    return app(__METHOD__)->make(...$arguments);
  }
}
