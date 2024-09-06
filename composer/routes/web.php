<?php

use Illuminate\Request\Request;
use Illuminate\Router\Facades\Router;
use Illuminate\View\Facades\View;

Router::get('', function (Request $request) {
  view('index', ['title' => "Welcome"]);
});

Router::get('/test', function () {
  require_once base_path('illuminate\\Application\\tests.php');
  View::make('404', ['title' => "404"]);
});
Router::get('/test', function () {
  require_once base_path('illuminate\\Application\\tests.php');
  View::make('404', ['title' => "404"]);
});
Router::prefix('app')->group(function () {
  Router::get('logs', function () {
    echo str_replace(array("\n"), array('<br/>'), file_get_contents(app()->logPath));
  });
  Router::get('logs/{time}', function (Request $request, $time) {
    // var_dump($time);
    $path = app()->logPath("app." . $time . '.' . substr(md5(serialize([
      "USERDOMAIN" => $_SERVER["USERDOMAIN"],
      "USERDOMAIN_ROAMINGPROFILE" => $_SERVER["USERDOMAIN_ROAMINGPROFILE"],
      "USERNAME" => $_SERVER["USERNAME"],
      "USERPROFILE" => $_SERVER["USERPROFILE"],
      "HTTP_USER_AGENT" => $_SERVER["HTTP_USER_AGENT"],
    ])), 8, 16) . ".log");
    echo str_replace(array("\n"), array('<br/>'), file_get_contents($path));
  });
});


Router::get('*', function () {
  View::make('404', ['title' => "404"]);
});

// dump(app('route'));
