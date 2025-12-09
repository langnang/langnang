<?php

namespace App\Http\Controllers;

use App\Models\Guide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GuideController extends Controller
{
  protected $table = "guides";

  public function index(Request $request, $slug = 'default')
  {
    $branches = DB::table($this->table)->where([
      ['parent', 0],
      ['type', 'branch'],
      ['status', 'public'],
    ])
      ->orderByDesc('order')
      ->orderBy('id')
      ->get();
    $categories = \App\Models\Guide::with(['children' => function ($query) {
      $query->orderBy('order')->where('type', 'category');
    }, 'sites' => function ($query) {
      $query->orderBy('order')->where('type', 'site');
    }])
      ->where('parent', '1')
      ->orderBy('order')
      ->get();
    return [
      "branches" => $branches,
      "categories" => $categories,
    ];
    return view('webstack.index')
      ->with('branches', $branches)
      ->with('categories', $categories);
  }

  //
  public function select_list(Request $request)
  {
    $parent = empty($request->input('parent')) ? 0 : $request->input('parent');
    $type = empty($request->input('type')) ? 'branch' : $request->input('type');
    $status = empty($request->input('status')) ? 'public' : $request->input('status');
    return DB::table($this->table)->where([
      ['parent', $parent],
      ['type', $type],
      ['status', $status],
    ])->orderByDesc('order')->orderBy('id')->paginate(PHP_INT_MAX);
  }
}
