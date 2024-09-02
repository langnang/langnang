<?php
$illuminate = basename(__DIR__);
var_dump($illuminate);
var_dump($_GET);

if (isset($_GET[__LINE__])) {
  var_dump(app()->aliases);
}

if (isset($_GET[__LINE__])) {
  var_dump(app()->aliases);
}
// 
if (isset($_GET[__LINE__])) {
  foreach (\glob(dirname(__DIR__) . '/*', GLOB_ONLYDIR) as $dir) {
    echo ('ILLUMINATE_IGNORES[]=' . basename($dir) . PHP_EOL . "<br/>");
    unset($dir);
  }
}

if (isset($_GET[__LINE__])) {
  foreach (\glob(dirname(__DIR__) . '/*', GLOB_ONLYDIR) as $dir) {
    echo ('**/illuminate/' . basename($dir) . '/**' . PHP_EOL . "<br/>");
    unset($dir);
  }
}
foreach (\glob(__DIR__ . '/../*/tests.php') as $file) {
  if (array_slice(preg_split('/\\\|\//', $file), -2, 1)[0] == 'Application') continue;
  require_once $file;
  unset($file);
}

unset($illuminate);
