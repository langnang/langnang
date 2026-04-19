<?php

namespace Modules\Admin\Http\Controllers\Framework;

use App\Providers\Route;

class AdminFrameworkOptionsController extends AdminFrameworkController
{
    public function __beforeConstruct()
    {
        $this->setModel([
            'alias' => 'option',
            'class' => \App\Models\Option::class,
        ]);
    }
}
