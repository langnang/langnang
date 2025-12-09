<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WebstackCategory;
use App\Models\Webstack\Site;

class WebstackController extends Controller
{
  public function index()
  {
    $categories = WebstackCategory::with(['children' => function ($query) {
      $query->orderBy('order');
    }, 'sites'])
      ->withCount('children')
      ->orderBy('order')
      ->get();

    return view('webstack.index')->with('categories', $categories);
  }

  public function about()
  {
    return view('webstack.about');
  }
}
