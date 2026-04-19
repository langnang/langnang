<?php

namespace Modules\Admin\Http\Controllers\Framework;


class AdminFrameworkSeedersController extends AdminFrameworkController
{
    public function index()
    {
        return $this->view('framework.database');
    }
}
