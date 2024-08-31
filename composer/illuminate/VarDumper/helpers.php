<?php

if (!function_exists('_dump')) {
  function _dump(...$arguments)
  {
    foreach (debug_backtrace() as $trace) {
      if ($trace['function'] == __FUNCTION__) {
        var_dump(app('var-dumper'));
        app('var-dumper')->print($trace);
      }
    }
  }
}
