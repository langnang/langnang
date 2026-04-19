<?php

namespace App\Http\Controllers\Admin\System;


class AdminSystemDatabaseController extends AdminSystemController
{
    public function index()
    {
        return $this->view('framework.database');
    }
}
