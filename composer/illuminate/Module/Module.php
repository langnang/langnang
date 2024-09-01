<?php

namespace Illuminate\Module;

class Module
{
  public $aliases = [];

  use Traits\LifeCycleMethods;

  function get($key = null)
  {
    if (empty($key)) {
      return $this->aliases;
    } else {
      return $this->aliases[$key];
    }
  }
}
