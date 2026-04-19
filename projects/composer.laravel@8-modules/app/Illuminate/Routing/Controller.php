<?php

namespace App\Illuminate\Routing;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Relations\HasMany;

abstract class Controller extends \Illuminate\Routing\Controller
{
    use \App\Traits\HasBladeViewTrait;
    use \App\Traits\HasModulesTrait;

    function __construct()
    {
        $this->_initModules();
    }
}
