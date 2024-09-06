<?php

use Illuminate\Router\Facades\Router;

Router::prefix(config('manual.alias'))->group(function () {
  Router::get('', '\Modules\Manual\Http\Controllers\ManualController@index');

  Router::get('{alias}', '\Modules\Manual\Http\Controllers\ManualController@alias');
  Router::get('{alias}/{illu}', '\Modules\Manual\Http\Controllers\ManualController@alias');
});

// dump(app('route'));
