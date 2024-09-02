<?php

use Illuminate\Route\Facades\Route;

Route::prefix(config('manual.alias'))->group(function () {
  Route::get('', '\Modules\Manual\Http\Controllers\ManualController@index');
});
