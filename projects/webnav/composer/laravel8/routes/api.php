<?php

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use ZanySoft\Zip\Zip;
use \wapmorgan\UnifiedArchive\UnifiedArchive;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix(module_env('PREFIX'))->group(function () {
  Route::match(['post'], '/insert_meta_item',  "Modules\WebStack\App\Http\Controllers\Controller@insert_meta_item");
  Route::match(['post'], '/insert_meta_list',  "Modules\WebStack\App\Http\Controllers\Controller@insert_meta_list");
  Route::match(['post'], '/delete_meta_item',  "Modules\WebStack\App\Http\Controllers\Controller@delete_meta_item");
  Route::match(['post'], '/delete_meta_list',  "Modules\WebStack\App\Http\Controllers\Controller@delete_meta_list");
  Route::match(['post'], '/update_meta_item',  "Modules\WebStack\App\Http\Controllers\Controller@update_meta_item");
  Route::match(['post'], '/update_meta_list',  "Modules\WebStack\App\Http\Controllers\Controller@update_meta_list");
  Route::match(['post'], '/upsert_meta_item',  "Modules\WebStack\App\Http\Controllers\Controller@upsert_meta_item");
  Route::match(['post'], '/upsert_meta_list',  "Modules\WebStack\App\Http\Controllers\Controller@upsert_meta_list");
  Route::match(['post'], '/release_meta_item',  "Modules\WebStack\App\Http\Controllers\Controller@release_meta_item");
  Route::match(['post'], '/release_meta_list',  "Modules\WebStack\App\Http\Controllers\Controller@release_meta_list");
  Route::match(['post'], '/select_meta_item',  "Modules\WebStack\App\Http\Controllers\Controller@select_meta_item");
  Route::match(['post'], '/select_meta_list',  "Modules\WebStack\App\Http\Controllers\Controller@select_meta_list");
  Route::match(['post'], '/select_meta_page',  "Modules\WebStack\App\Http\Controllers\Controller@select_meta_page");
  Route::match(['post'], '/select_meta_tree',  "Modules\WebStack\App\Http\Controllers\Controller@select_meta_tree");
  Route::match(['post'], '/import_meta',  "Modules\WebStack\App\Http\Controllers\Controller@import_meta");
  Route::match(['post'], '/export_meta',  "Modules\WebStack\App\Http\Controllers\Controller@export_meta");


  Route::match(['post'], '/',  "Modules\WebStack\App\Http\Controllers\Controller@view_index");
  Route::match(['post'], '/',  "Modules\WebStack\App\Http\Controllers\Controller@view_index");
  Route::match(['post'], '/',  "Modules\WebStack\App\Http\Controllers\Controller@view_index");
  Route::match(['post'], '/',  "Modules\WebStack\App\Http\Controllers\Controller@view_index");
  Route::match(['post'], '/',  "Modules\WebStack\App\Http\Controllers\Controller@view_index");
  Route::match(['post'], '/',  "Modules\WebStack\App\Http\Controllers\Controller@view_index");
  Route::match(['post'], '/',  "Modules\WebStack\App\Http\Controllers\Controller@view_index");
  Route::match(['post'], '/',  "Modules\WebStack\App\Http\Controllers\Controller@view_index");
  Route::match(['post'], '/',  "Modules\WebStack\App\Http\Controllers\Controller@view_index");
  Route::match(['post'], '/',  "Modules\WebStack\App\Http\Controllers\Controller@view_index");
  Route::match(['post'], '/',  "Modules\WebStack\App\Http\Controllers\Controller@view_index");
  Route::match(['post'], '/',  "Modules\WebStack\App\Http\Controllers\Controller@view_index");
  Route::match(['post'], '/',  "Modules\WebStack\App\Http\Controllers\Controller@view_index");
  Route::match(['post'], '/',  "Modules\WebStack\App\Http\Controllers\Controller@view_index");
  Route::match(['post'], '/',  "Modules\WebStack\App\Http\Controllers\Controller@view_index");
  Route::match(['post'], '/',  "Modules\WebStack\App\Http\Controllers\Controller@view_index");
  Route::match(['post'], '/',  "Modules\WebStack\App\Http\Controllers\Controller@view_index");
  foreach (config('app.controllers') as $prefix => $controller) {
    if (in_array($prefix, ['user', 'option'])) continue;
    Route::group(['prefix' => $prefix], function () use ($controller) {
      foreach ([

        '',
        '',


        'insert_content_item',
        'insert_content_list',
        'delete_content_item',
        'delete_content_list',
        'update_content_item',
        'update_content_list',
        'upsert_content_item',
        'upsert_content_list',
        'select_content_item',
        'select_content_list',
        'select_content_page',
        'select_content_tree',

        'staging_content_item',
        'staging_content_list',
        'release_content_item',
        'release_content_list',

        'import_content',
        'export_content',

      ] as $func) {
        Route::match(['post'], '/' . $func, $controller . "@" . $func);
      }
    });
  }
});
