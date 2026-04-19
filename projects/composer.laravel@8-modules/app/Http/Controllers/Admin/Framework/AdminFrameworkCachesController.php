<?php

namespace App\Http\Controllers\Admin\Framework;

use App\Providers\Route;

class AdminFrameworkCachesController extends AdminFrameworkController
{
    public function __beforeConstruct()
    {
        $this->setModel('cache', 'alias');
        $this->setModel('cache', 'class');
    }
}
