<?php


return [
    "name" => "",

    "version" => "",

    "core" => [
        'auth' => \App\Core\Auth::class,
        'autoload' => \App\Core\Autoload::class,
        'config' => \App\Core\Config::class,
        'db' => \App\Core\DB::class,
        'env' => \App\Core\Env::class,
        'filesystem' => \App\Core\FileSystem::class,
        'log' => \App\Core\Log::class,
        'module' => \App\Core\Env::class,
        'request' => \App\Core\Request::class,
        'response' => \App\Core\Response::class,
        'router' => \App\Core\Router::class,
        'selector' => \App\Core\Selector::class,
        'spider' => \App\Core\Spider::class,
        'var_dump' => \App\Core\VarDump::class,
        'view' => \App\Core\View::class,
    ],

    "supports" => [],
];
