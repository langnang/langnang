<?php

use Illuminate\Support\Facades\Route;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
// use Modules\Admin\App\Http\Controllers\Controller;
// require_once __DIR__ . '/../app/Http/Controllers/Controller.php';
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

Route::prefix(module_env('PREFIX'))->group(function () {
  Route::match(['get'], '',  "Modules\WebStack\App\Http\Controllers\Controller@view_index");
  Route::match(['get'], '/meta/{mid}',  "Modules\WebStack\App\Http\Controllers\Controller@view_meta_item");
  Route::match(['get'], '/meta-form',  "Modules\WebStack\App\Http\Controllers\Controller@view_meta_list_form");
  Route::match(['get'], '/meta-form/{mid}',  "Modules\WebStack\App\Http\Controllers\Controller@view_meta_item_form");
  Route::match(['get'], '/content/{cid}',  "Modules\WebStack\App\Http\Controllers\Controller@view_content_item");
  Route::match(['get'], '/content-form',  "Modules\WebStack\App\Http\Controllers\Controller@view_content_list_form");
  Route::match(['get'], '/content-form/{mid}',  "Modules\WebStack\App\Http\Controllers\Controller@view_content_item_form");
  Route::match(['get'], '/tree/{slug}',  "Modules\WebStack\App\Http\Controllers\Controller@view_tree");
  Route::match(['get'], '/discover',  "Modules\WebStack\App\Http\Controllers\Controller@view_spider_discover_list");
  Route::match(['get'], '/discover/{spider_cid}/{discover_index?}',  "Modules\WebStack\App\Http\Controllers\Controller@view_spider_discover_item");
  Route::match(['get'], '/sourceSearch',  "Modules\WebStack\App\Http\Controllers\Controller@view_spider_search_list");
  Route::match(['get'], '/options',  "Modules\WebStack\App\Http\Controllers\Controller@view_options");
  Route::match(['get'], '/404',  "Modules\WebStack\App\Http\Controllers\Controller@view_404");
});
