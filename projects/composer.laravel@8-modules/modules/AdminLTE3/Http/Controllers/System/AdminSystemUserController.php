<?php

namespace Modules\Admin\Http\Controllers\System;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class AdminSystemUserController extends AdminSystemController
{
    public function __beforeConstruct()
    {
        $this->setModel([
            'alias' => 'user',
            'class' => \App\Models\User::class,
        ]);
    }
    public function index()
    {
        $return = $this->getReturn();

        $_where = [];
        request()->whenFilled('name', function ($value) use (&$_where) {
            $_where[] = ['name', 'like', '%' . $value . '%'];
        });
        request()->whenFilled('title', function ($value) use (&$_where) {
            $_where[] = ['title', 'like', '%' . $value . '%'];
        });
        request()->whenFilled('slug', function ($value) use (&$_where) {
            $_where[] = ['slug', 'like', '%' . $value . '%'];
        });
        request()->whenFilled('type', function ($value) use (&$_where) {
            $_where[] = ['type', $value];
        });
        request()->whenFilled('status', function ($value) use (&$_where) {
            $_where[] = ['status', $value];
        });

        $return['paginator'] = $paginator = $return['paginator'] ?? select_page([
            '$model' => request()->input('$model', $this->getModel('class')),
            '$where' => $_where,
            '$orderByDesc' => 'updated_at',
            '$size' => request()->input('$size', 15),
        ]);

        $this->mergeReturn($return);
        $view = Arr::get($return, 'view', 'system.' . $this->getModel('alias') . '-table');
        return $this->view($view, $return);
    }
}
