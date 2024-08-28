<?php

namespace App\Core;

class Application
{
    function __construct()
    {
        var_dump(__METHOD__);
        $cfg = require_once __DIR__ . '/../../config/app.php';
        var_dump($cfg);

        // load core modules
        foreach ($cfg['core'] as $alias => $core) {
            if (is_int($alias))
                $alias = $core;

            $this->{$alias} = new $core;
        }
        // load helpers
        // foreach ($cfg['supports'] as $support) {
        // require_once $support;
        // }
    }
    function singleton() {}
    function run()
    {
        $this->router->run();
    }

    function __call($name, $arguments)
    {
        var_dump(__FUNCTION__, $name, $arguments);
    }

    static function __callStatic($name, $arguments)
    {
        var_dump(__FUNCTION__, $name, $arguments);
    }

    function __destruct()
    {
        var_dump(__FUNCTION__);
    }

    function __get($name)
    {
        var_dump(__FUNCTION__, $name);
    }

    function __set($name, $value)
    {
        var_dump(__FUNCTION__);
        $this->{$name} = $value;
    }

    function __isset($name)
    {
        var_dump(__FUNCTION__);
    }

    function __unset($name)
    {
        var_dump(__FUNCTION__);
    }

    function __sleep()
    {
        var_dump(__FUNCTION__);
    }

    function __wakeup()
    {
        var_dump(__FUNCTION__);
    }

    function __serialize()
    {
        var_dump(__FUNCTION__);
    }

    function __unserialize()
    {
        var_dump(__FUNCTION__);
    }

    function __toString()
    {
        var_dump(__FUNCTION__);
    }

    function __invoke()
    {
        var_dump(__FUNCTION__);
    }

    function __set_state()
    {
        var_dump(__FUNCTION__);
    }

    function __clone()
    {
        var_dump(__FUNCTION__);
    }

    function __debugInfo()
    {
        var_dump(__FUNCTION__);
    }
}
