<?php

use Illuminate\Route\Facades\Route;

Route::prefix(config('welcome.alias'))->group(function () {
  Route::get('', '\Modules\Welcome\Http\Controllers\WelcomeController@index');
});
