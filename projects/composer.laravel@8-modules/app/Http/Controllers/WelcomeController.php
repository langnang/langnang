<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Route;

class WelcomeController extends \App\Illuminate\Routing\Controller
{

    static function webRoutes()
    {
        Route::get('/', [static::class, 'index'])->name('welcome');
    }
    public function index()
    {
        // var_dump(\Module::allEnabled());
        $return = [
            // 'view' => 'welcome',
            // 'modules' => [],
            // 'layouts' => [],
            // 'components' => [],
            // 'languages' => [],
            'modules' => $this->getModules(),
        ];
        \Debugbar::info(__METHOD__, $return);
        return $this->view('welcome', $return);
    }
}
