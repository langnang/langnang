<?php

namespace App\Traits;

/**
 * Summary of HasWebMethodsTrait
 */
trait HasWebMethodsTrait
{
    /**
     * Display a paging list of the resource.
     * 显示资源的分页列表
     * @return Renderable
     */
    public function index() {}
    public function page() {}
    public function list() {}

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id) {}
}
