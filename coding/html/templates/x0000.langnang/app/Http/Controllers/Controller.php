<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helpers\ArrayHelper;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     title="My First API",
 *     version="0.1"
 * )
 */
class Controller extends BaseController
{
  use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

  /**
   * @var string 表名
   */
  protected $table;

  public function insert_item(Request $request)
  {
    $item = $request->query();
    $id = DB::table($this->table)->insertGetId($request->query());
    $item['id'] = $id;
    return $item;
  }

  public function insert_list(Request $request)
  {
    DB::table($this->table)->insertGetId($request->query());
    return response("Success");
  }

  public function delete_item(Request $request)
  {
  }

  public function delete_list(Request $request)
  {
  }

  public function update_item(Request $request)
  {
  }

  public function update_list(Request $request)
  {
  }

  public function replace_item(Request $request)
  {
  }

  public function replace_list(Request $request)
  {
  }

  public function select_item(Request $request)
  {
  }

  public function select_rand(Request $request)
  {
    return DB::table($this->table)
      ->inRandomOrder()
      ->first();
  }

  public function select_list(Request $request)
  {
    return DB::table($this->table)->paginate(20);
  }

  public function select_tree(Request $request): array
  {
    $paginator = DB::table($this->table)
      ->select(DB::raw("{$this->table}.*, concat(parent,id) p"))
      ->orderBy("p", "asc")
      ->paginate(PHP_INT_MAX);
    $tree = ArrayHelper::list_to_tree($paginator->items(), "id", "parent");
    $paginator->tree = $tree;
    return array_merge($paginator->toArray(), ["tree" => $tree]);
  }

  public function file_upload()
  {
  }

  public function file_download()
  {
  }

  public function count_increase()
  {
  }

  public function count_decrease()
  {
  }
}
