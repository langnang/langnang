<?php

namespace App\Traits;

/**
 * Summary of HasReturn
 */
trait HasApiMethodsTrait
{

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     * @param 
     * @return Renderable
     */
    public function store() {}

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id) {}

    /**
     * Update the specified resource in storage.
     * @param 
     * @param int $id
     * @return Renderable
     */
    public function update($id) {}

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id) {}

    public function import() {}

    public function export() {}

    public function factory() {}
}
