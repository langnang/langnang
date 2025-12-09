<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
  return $request->user();
});

Route::prefix('guide_content')->group(function () {
  foreach (['insert_item', 'select_rand', 'select_list', 'select_tree'] as $path) {
    Route::get($path, [App\Http\Controllers\GuideContentController::class, $path]);
  }
});

Route::prefix('guide')->group(function () {
  foreach (['insert_item', 'select_rand', 'select_list', 'select_tree'] as $path) {
    Route::get($path, [App\Http\Controllers\GuideController::class, $path]);
  }
});
/**
 * @OA\Get(
 *     path="/projects",
 *     @OA\Response(response="200", description="Display a listing of projects.")
 * )
 */
