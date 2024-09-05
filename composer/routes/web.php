<?php

use Illuminate\Request\Request;
use Illuminate\Route\Facades\Route;
use Illuminate\View\Facades\View;

Route::get('', function (Request $request) {
  view('index', ['title' => "Welcome"]);
});

Route::get('/test', function () {
  require_once base_path('illuminate\\Application\\tests.php');
  View::make('404', ['title' => "404"]);
});
Route::get('/test', function () {
  require_once base_path('illuminate\\Application\\tests.php');
  View::make('404', ['title' => "404"]);
});
Route::prefix('app')->group(function () {
  Route::get('logs', function () {
    echo str_replace(array("\n"), array('<br/>'), file_get_contents(app()->logPath));
  });
  Route::get('logs/{time}', function (Request $request, $time) {
    // var_dump($time);
    $path = app()->logPath("app." . $time . ".log");
    echo str_replace(array("\n"), array('<br/>'), file_get_contents($path));
  });
});


Route::get('*', function () {
  View::make('404', ['title' => "404"]);
});

// dump(app('route'));
