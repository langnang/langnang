<?php

namespace App\Http\Controllers\Admin\Ssential;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Illuminate\Routing\Controller;
use Route;

class AdminSsentialLinkController extends AdminSsentialController
{
    public function __beforeConstruct()
    {
        $this->setModel([
            'alias' => 'link',
            'class' => \App\Models\Link::class,
            'validations' => [
                'item' => [
                    'title' => 'required|string',
                    'url' => 'required|string',
                    'type' => 'required|string',
                    'status' => 'required|string',
                ],
                'list' => [
                    'ids' => 'required|string',
                    'operation' => 'required|string',
                ]
            ],
        ]);
    }
}
