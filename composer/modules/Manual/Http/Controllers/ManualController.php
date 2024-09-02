<?php

namespace Modules\Manual\Http\Controllers;

class ManualController
{
  /**
   * Display a listing of the resource.
   * @return Renderable
   */
  public function index()
  {
    return view('manual::index', [
      'title' => "Manual",
      "illuminates" => app()->aliases,
      "modules" => module()
      // "modules"=>
    ]);
  }

  /**
   * Show the form for creating a new resource.
   * @return Renderable
   */
  public function create()
  {
    return view('manual::create');
  }

  /**
   * Store a newly created resource in storage.
   * @param Request $request
   * @return Renderable
   */
  public function store(Request $request)
  {
    //
  }

  /**
   * Show the specified resource.
   * @param int $id
   * @return Renderable
   */
  public function show($id)
  {
    return view('manual::show');
  }

  /**
   * Show the form for editing the specified resource.
   * @param int $id
   * @return Renderable
   */
  public function edit($id)
  {
    return view('manual::edit');
  }

  /**
   * Update the specified resource in storage.
   * @param Request $request
   * @param int $id
   * @return Renderable
   */
  public function update(Request $request, $id)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   * @param int $id
   * @return Renderable
   */
  public function destroy($id)
  {
    //
  }
}