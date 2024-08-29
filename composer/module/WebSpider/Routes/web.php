<?php

use App\Illuminate\Router\Facades\Router;

Router::prefix('webspider')->group(function () {
  Route::get('/', 'BlogController@index');
});
