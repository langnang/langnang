<?php


foreach (\glob(__DIR__ . '/../*/tests.php') as $file) {
  if (array_slice(preg_split('/\\\|\//', $file), -2, 1)[0] == 'Application') continue;
  require_once $file;
}
