<?php
$illuminate = basename(__DIR__);


// Route::get('', function () {});
Route::get('1', function () {});
Route::get('/2', function () {});
Route::get(' /2 ', function () {});

if (array_key_exists($illuminate, $_GET) & isset($_GET[__LINE__])) {
  var_dump(app('route'));
}
unset($illuminate);
