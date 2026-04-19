<?php

namespace Modules\Admin\Http\Controllers\Framework;

use App\Providers\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class AdminFrameworkController extends \Modules\Admin\Http\Controllers\AdminController
{
    public function __beforeConstruct()
    {
        $this->setModel([
            'alias' => 'framework',
            'class' => 'frameworks',
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
            '$size' => request()->input('$size', 15),
        ]);

        $this->mergeReturn($return);
        $view = Arr::get($return, 'view', 'framework.' . $this->getModel('alias') . '-table');
        return $this->view($view, $return);
    }
}
