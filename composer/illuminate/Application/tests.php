<?php

$illuminate = basename(__DIR__);

if (array_key_exists($illuminate, $_GET) & isset($_GET[__LINE__])) {
  var_dump(app()->aliases);
}

if (array_key_exists($illuminate, $_GET) & isset($_GET[__LINE__])) {
  var_dump(app()->aliases);
}
// 
if (array_key_exists($illuminate, $_GET) & isset($_GET[__LINE__])) {
  foreach (\glob(dirname(__DIR__) . '/*', GLOB_ONLYDIR) as $dir) {
    echo ('ILLUMINATE_IGNORES[]=' . basename($dir) . PHP_EOL . "<br/>");
    unset($dir);
  }
}

if (array_key_exists($illuminate, $_GET) & isset($_GET[__LINE__])) {
  foreach (\glob(dirname(__DIR__) . '/*', GLOB_ONLYDIR) as $dir) {
    echo ('**/illuminate/' . basename($dir) . '/**' . PHP_EOL . "<br/>");
    unset($dir);
  }
}
foreach (\glob(__DIR__ . '/../*/tests.php') as $file) {
  $filename = array_slice(preg_split('/\\\|\//', $file), -2, 1)[0];
  if (in_array($filename, $_ENV['ILLUMINATE_IGNORES'])) continue;
  if ($filename == 'Application') continue;
  require_once $file;
  unset($file);
}

unset($illuminate);
