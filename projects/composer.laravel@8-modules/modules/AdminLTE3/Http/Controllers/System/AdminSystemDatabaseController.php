<?php

namespace Modules\Admin\Http\Controllers\System;


class AdminSystemDatabaseController extends AdminSystemController
{
    public function index()
    {
        return $this->view('framework.database');
    }
}
