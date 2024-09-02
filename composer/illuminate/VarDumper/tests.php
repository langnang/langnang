<?php

$illuminate = basename(__DIR__);

if (array_key_exists($illuminate, $_GET) & isset($_GET[__LINE__])) {
  $arg = config('config');
}
if (array_key_exists($illuminate, $_GET) & isset($_GET[__LINE__])) {
  $arg = config('module');
}
if (array_key_exists($illuminate, $_GET) & isset($_GET[__LINE__])) {
  $arg = debug_backtrace()[2];
}
if (array_key_exists($illuminate, $_GET) & isset($_GET[__LINE__])) {
  foreach ([99999, "99999", null, debug_backtrace()[2]] as $arg) {
    var_dump($arg);
    dump($arg);
    _dump($arg);
  }
}
if (array_key_exists($illuminate, $_GET) & isset($_GET[__LINE__])) {
  var_dump(gettype(null));
}




unset($arg);
unset($illuminate);
