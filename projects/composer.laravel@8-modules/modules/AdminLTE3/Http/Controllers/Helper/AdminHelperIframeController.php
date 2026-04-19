<?php

namespace Modules\Admin\Http\Controllers\Helper;


class AdminHelperIframeController extends AdminHelperController
{
    public function index()
    {
        return $this->view('helper.iframe');
    }
}
