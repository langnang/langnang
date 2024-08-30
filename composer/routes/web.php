<?php

use Illuminate\Request\Request;
use Illuminate\Route\Facades\Route;
use Illuminate\View\Facades\View;

Route::get('', function (Request $request) {
  view('index', ['title' => "Langnang"]);
});


Route::get('/test', function () {
  require_once base_path('illuminate\\Application\\tests.php');
  View::make('404', ['title' => "404"]);
});
Route::get('*', function () {
  View::make('404', ['title' => "404"]);
});
