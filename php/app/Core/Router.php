<?php

namespace App\Core;

class Router
{
    public $maps = [];
    public $routes = [];
    function run()
    {
        var_dump($_SERVER);
        var_dump($this->routes);
        $func = $this->routes[$_SERVER['PATH_INFO']][$_SERVER['REQUEST_METHOD']];

        $func($this);
        // $method();
        // $method = $_SERVER['REQUEST_METHOD'];
    }
    function group() {}
    function any($methods, $path, $func) {}
    function get($path, $func)
    {
        if (!isset($this->routes[$path])) $this->routes[$path] = [];
        $this->routes[$path]['GET'] = $func;
        // var_dump(__METHOD__);
        // var_dump(__FUNCTION__);
    }
    function post() {}
}
