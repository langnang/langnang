<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
  return view('home.index');
});
Route::view('/mdms/{book?}/{chapter?}', 'mdms.index', [
  "title" => "", "description" => "", "keywords" => "", "prev" => "home",
  "next" => "function", "menu" => [
    "title" => "DuxCms说明",
    "slug" => "home",
    "children" => [
      ["title" => "安装与环境", "slug" => "function"],
      ["title" => "版权协议"],
      [
        "title" => "模板基础",
        "children" => [
          ["title" => "目录与结构说明"],
          ["title" => "基础标签格式"],
        ]
      ],
      ["title" => "安装与环境"],
      ["title" => "安装与环境"],
      ["title" => "安装与环境"],
    ],
  ]
]);

//Route::get('/guide', [\App\Http\Controllers\GuideController::class, 'index']);
//Route::get('/webstack/about', [\App\Http\Controllers\WebstackController::class, 'about']);
Route::get('/guide/{slug?}', [\App\Http\Controllers\GuideController::class, 'index']);
