<?php

use App\Illuminate\Request\Request;
use \App\Illuminate\Router\Facades\Router;
use \App\Illuminate\View\Facades\View;

Router::get('', function (Request $request) {
  view('index', ['title' => "Langnang"]);
});


Router::get('/123123', function () {
  echo "123";
});
Router::get('*', function () {
  View::make('404', ['title' => "404"]);
});
// $app->config();
Router::prefix('webspider')->group(function () {
  Router::get('/', function () {
    echo "webspider";
  });
  Router::get('', function () {
    echo "webspider";
  });
});
