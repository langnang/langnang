<?php

use Illuminate\Http\Client\Request;
use SebastianBergmann\Type\NullType;

if (!function_exists('')) {
    /**
     * @method cache_remember
     * @param callable $callback
     * @param bool|null $strict = false
     * @param int|null $breadth = 0
     */
    function cache_remember(callable $callback, $strict = false, $breadth = 0)
    {
        $breadth = $breadth > 0 ? $breadth : 0;
        $trace_0 = debug_backtrace()[0 + $breadth];
        $trace_1 = debug_backtrace()[1 + $breadth];
        $path = substr($trace_0['file'], strlen(dirname(__DIR__)));
        $pathinfo = pathinfo($path);
        if ($strict) {
            $key = md5(json_encode([
                'url' => request()->url(),
                'fullUrl' => request()->fullUrl(),
            ], JSON_UNESCAPED_UNICODE)) . "{" . $path . "}[" . $trace_1['function'] . "](" . $trace_0['line'] . ")";
        } else {
            $key = md5(json_encode([
                'url' => request()->url(),
            ], JSON_UNESCAPED_UNICODE)) . "{" . $path . "}[" . $trace_1['function'] . "](" . $trace_0['line'] . ")";
        }
        // dump($trace_0, $trace_1, $path, $pathinfo, $key);
        return \Cache::remember($key, config('cache.seconds'), $callback);
    }
}
