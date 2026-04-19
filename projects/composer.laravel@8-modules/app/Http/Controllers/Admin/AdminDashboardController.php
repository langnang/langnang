<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;

class AdminDashboardController extends AdminController
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $this->_call(__FUNCTION__, 'before',);
        $return = [
            'metas_count' => select_count([
                '$model' => \App\Models\Meta::class,
            ]),
            'contents_count' => select_count([
                '$model' => \App\Models\Content::class,
            ]),
            'links_count' => select_count([
                '$model' => \App\Models\Link::class,
            ]),
            'files_count' => select_count([
                '$model' => \App\Models\File::class,
            ]),
            // 'contents_latest' => select_page([
            //     '$model' => \App\Models\Content::class,
            //     '$size' => 10,
            // ]),
            // 'links_latest' => select_page([
            //     '$model' => \App\Models\Link::class,
            //     '$size' => 10,
            // ]),
            // 'files_latest' => select_page([
            //     '$model' => \App\Models\File::class,
            //     '$size' => 10,
            // ]),
        ];
        $this->_call(__FUNCTION__, '_after', $return);
        return $this->view('dashboard', $return);
    }
}
