<?php
if (false) {
  var_dump(app()->aliases);
}
// 
if (false) {
  foreach (\glob(dirname(__DIR__) . '/*', GLOB_ONLYDIR) as $dir) {
    echo ('ILLUMINATE_IGNORES[]=' . basename($dir) . PHP_EOL . "<br/>");
    unset($dir);
  }
}

foreach (\glob(__DIR__ . '/../*/tests.php') as $file) {
  if (array_slice(preg_split('/\\\|\//', $file), -2, 1)[0] == 'Application') continue;
  require_once $file;
  unset($file);
}
