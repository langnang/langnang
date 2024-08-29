<?php

use Illuminate\Request\Request;
use Illuminate\Route\Facades\Route;
use Illuminate\View\Facades\View;

Route::get('', function (Request $request) {
  view('index', ['title' => "Langnang"]);
});


Route::get('/123123', function () {
  echo "123";
});
Route::get('*', function () {
  View::make('404', ['title' => "404"]);
});
