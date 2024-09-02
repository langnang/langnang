<?php

namespace Illuminate\Application\Traits;

trait LifeCycleMethods
{
  function _() {}

  function _init() {}

  function _autoload(...$arguments)
  {
    foreach ($this->aliases as $alias => $illuminate) {
      if (method_exists($illuminate, __FUNCTION__)) {
        $illuminate->{__FUNCTION__}(...$arguments);
      }
    }
  }


  function _run(...$arguments)
  {
    foreach ($this->aliases as $alias => $illuminate) {
      if (method_exists($illuminate, __FUNCTION__)) {
        $illuminate->{__FUNCTION__}(...$arguments);
      }
    }
  }
}
