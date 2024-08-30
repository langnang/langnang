<?php

// $arg = config('config');
// $arg = config('module');
// $arg = debug_backtrace()[2];
foreach ([99999, "99999", null, debug_backtrace()[2]] as $arg) {
  var_dump($arg);
  _dump($arg);
}
// var_dump(gettype(null));




unset($arg);
