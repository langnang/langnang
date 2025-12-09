<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Dcat\Admin\Admin;

Admin::routes();

Route::group([
  'prefix'        => config('admin.route.prefix'),
  'namespace'     => config('admin.route.namespace'),
  'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

  $router->get('/', 'HomeController@index');

  $router->get('/auth/setting', 'AuthController@getSetting');
  $router->get('/auth/users', 'UserController@index');

  $router->get('/webstack', 'WebstackController@index');
});
