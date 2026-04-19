<?php

namespace App\Http\Controllers\Admin\Framework;

use Illuminate\Support\Facades\Artisan;


class AdminFrameworkMigrationsController extends AdminFrameworkController
{
    public function __beforeConstruct()
    {
        $this->setModel([
            'alias' => 'migration',
            'class' => 'migrations',
        ]);
    }
}
