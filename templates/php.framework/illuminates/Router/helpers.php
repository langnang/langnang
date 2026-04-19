<?php

if (!function_exists('routes')) {
  function routes()
  {
    return app('router')->getRoutes();
  }
}
