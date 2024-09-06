<?php

use Illuminate\Router\Facades\Router;

Router::prefix(config('welcome.alias'))->group(function () {
  Router::get('', '\Modules\Welcome\Http\Controllers\WelcomeController@index');
});
