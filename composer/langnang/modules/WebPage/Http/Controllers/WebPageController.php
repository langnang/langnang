<?php

namespace Modules\WebPage\Http\Controllers;

class WebPageController extends \Illuminate\Controller\Controller
{
  /**
   * Display a listing of the resource.
   * @return Renderable
   */
  public function index()
  {
    return view('webpage::index', [
      'title' => "Manual",
      "illuminates" => app()->get_aliases(),
      "modules" => module()
      // "modules"=>
    ]);
  }
}
