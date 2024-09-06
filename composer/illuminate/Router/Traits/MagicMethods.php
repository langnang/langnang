<?php

namespace Illuminate\Router\Traits;

trait MagicMethods
{
  function __set($name, $value)
  {
    $this->{$name} = $value;
  }

  function __log() {}
}
