<?php

namespace Modules\Admin\Http\Controllers\Helper;


class AdminHelperChromeController extends \Modules\Admin\Http\Controllers\AdminController
{
    public function index()
    {
        return $this->view('helper.chrome');
    }
}
