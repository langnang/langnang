<?php

namespace App\Http\Controllers\Admin\Helper;


class AdminHelperIframeController extends AdminHelperController
{
    public function index()
    {
        return $this->view('helper.iframe');
    }
}
