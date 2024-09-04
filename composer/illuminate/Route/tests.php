<?php
$illuminate = basename(__DIR__);


// Route::get('', function () {});
// ?Route&7
if (array_key_exists($illuminate, $_GET) & isset($_GET[__LINE__])) {
  Route::get('1', function () {});
}
if (array_key_exists($illuminate, $_GET) & isset($_GET[__LINE__])) {
  Route::get('/2', function () {});
}
if (array_key_exists($illuminate, $_GET) & isset($_GET[__LINE__])) {
  Route::get(' /2 ', function () {});
}
if (array_key_exists($illuminate, $_GET) & isset($_GET[__LINE__])) {
  dump(app('route'));
}

unset($illuminate);
