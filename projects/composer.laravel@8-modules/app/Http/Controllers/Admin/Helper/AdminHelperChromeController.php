<?php

namespace App\Http\Controllers\Admin\Helper;


class AdminHelperChromeController extends \Modules\Admin\Http\Controllers\AdminController
{
    public function index()
    {
        return $this->view('helper.chrome');
    }
}
