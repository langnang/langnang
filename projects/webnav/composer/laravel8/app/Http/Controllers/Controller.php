<?php

namespace Modules\WebStack\App\Http\Controllers;

use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\Request;

class Controller extends \App\Http\Controllers\Controller
{
  use \App\Traits\Modules\WebStackTrait;
  use WebStackView;

  protected $MetaModel = \App\Models\WebStack\WebStackMeta::class;
  protected $ContentModel = \App\Models\WebStack\WebStackContent::class;
  protected $LinkModel = \App\Models\WebStack\WebStackLink::class;

  public function branches(Request $request)
  {
    $result = \App\Models\WebStack\WebStackMeta::where([['type', 'branch'], ['parent', 0]])->get();
    return $this->success($result, '查询成功');
  }

  public function select_tree(Request $request)
  {
    try {
      $request->merge(['$model' => $this->MetaModel, '$with' => ['children', 'contents' => function ($query) {
        return $query->where([['type', 'post'], ['status', 'publish']]);
      }]]);
      $where = [];
      if ($request->filled('name')) array_push($where, ['name', 'like', '%' . $request->input('name') . '%']);
      if ($request->filled('slug')) array_push($where, ['type', $request->input('slug')]);
      if ($request->filled('type')) array_push($where, ['type', $request->input('type')]);
      if ($request->filled('status')) array_push($where, ['type', $request->input('status')]);
      if ($request->filled('parent')) array_push($where, ['parent', $request->input('parent')]);
      $request->merge(['$where' => $where]);
      return parent::select_tree($request);
    } catch (Exception $e) {
      return $this->error($e);
    }
  }

  public function index(Request $request)
  {
    return redirect('/webstack/tree/default');
  }

  public function about(Request $request)
  {
    $branches = $this->select_meta_list(new Request(['type' => 'category', 'parent' => 0, 'status' => 'publish']));
    return view('webstack.about', [
      "prefix" => $request->route()->getPrefix(),
      'branches' => $branches
    ]);
  }

  public function not_found(Request $request)
  {
    $branches = $this->select_meta_list(new Request(['type' => 'category', 'parent' => 0, 'status' => 'publish']));
    return view('webstack.404', [
      "prefix" => $request->route()->getPrefix(),
      'branches' => $branches
    ]);
  }

  public function tree(Request $request, $slug = 'default')
  {
    $branches = $this->select_meta_list(new Request(['type' => 'category', 'parent' => 0]));
    // dump($branches);
    $branch = [];
    for ($i = 0; $i < $branches->count(); $i++) {
      if ($branches[$i]->slug == $slug) $branch = $branches[$i];
    }
    if (empty($branch)) return redirect('/webstack/404');
    // var_dump($branch);
    $tree = $this->select_tree(new Request(['parent' => $branch->mid, 'type' => 'category']));
    // var_dump($tree->toArray());
    return view('webstack.index', [
      "prefix" => $request->route()->getPrefix(),
      "branches" => $branches,
      "tree" => $tree,
    ]);
  }

  public function content_item(Request $request, $cid)
  {
    return view('webstack.content.item', []);
  }
}

trait WebStackView
{
  /**
   * OPEN /{prefix}
   * @param Request $request
   * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
   */
  public function view_index(Request $request)
  {
    $return = parent::{__FUNCTION__}($request);
    $return = $return->getData();

    if ($request->filled('mid')) {
      $return['tree'] = $return['categories'][$request->input('mid')];
    } else {
      $return['tree'] = $return['categories'][0];
    }
    echo "<script>window.\$data=" . json_encode($return, JSON_UNESCAPED_UNICODE) . "</script>";
    return view($return['view'], $return);
  }
}
