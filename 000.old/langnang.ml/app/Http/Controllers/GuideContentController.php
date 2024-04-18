<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Helpers\ArrayHelper;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="guide_content",
 *     description="导航内容"
 * )
 */
class GuideContentController extends Controller
{
  protected $table = "guide_contents";
  /**
   * @OA\Get(
   *     path="/api/guide_content/select_tree",
   *     tags={"guide_content"},
   *     @OA\Response(
   *         response="200",
   *         description="The data"
   *     )
   * )
   */
  public function select_tree(Request $request)
  {
    $parent = $request->input('parent', 0);
    var_dump($parent);
    $list = DB::table($this->table)
      ->select(DB::raw("{$this->table}.*, concat(parent,id) p"))
      ->orderBy("p", "asc")
      ->get();
    $tree = ArrayHelper::list_to_tree($list->all(), "id", "parent");
    // return $list;
    // $paginator->tree = $tree;
    // $result = array_merge($paginator->toArray(), ["tree" => $tree]);
    // return $result;
    return ["list" => $list, "tree" => $tree, "total" => $list->count()];
  }
}
