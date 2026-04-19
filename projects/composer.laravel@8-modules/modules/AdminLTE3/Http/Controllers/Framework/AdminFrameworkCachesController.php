<?php

namespace Modules\Admin\Http\Controllers\Framework;

use App\Providers\Route;

class AdminFrameworkCachesController extends AdminFrameworkController
{
    public function __beforeConstruct()
    {
        $this->setModel('cache', 'alias');
        $this->setModel('cache', 'class');
    }
}
