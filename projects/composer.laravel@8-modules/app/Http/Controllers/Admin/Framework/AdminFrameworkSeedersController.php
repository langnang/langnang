<?php

namespace App\Http\Controllers\Admin\Framework;


class AdminFrameworkSeedersController extends AdminFrameworkController
{
    public function index()
    {
        return $this->view('framework.database');
    }
}
