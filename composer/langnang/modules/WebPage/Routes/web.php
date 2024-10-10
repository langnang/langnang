<?php


Route::prefix('webpage')->group(function () {
  Route::get('', '\Modules\WebPage\Http\Controllers\WebPageController@index');
});
