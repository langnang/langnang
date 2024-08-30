<?php

namespace Illuminate\Application\Traits;

trait LifeCycleMethods
{
  function _() {}

  function _init() {}

  function _autoload(...$arguments)
  {
    foreach ($this->aliases as $alias => $illuminate) {
      if (method_exists($illuminate, __METHOD__)) {
        $illuminate->{__METHOD__}(...$arguments);
      }
    }
  }


  function _run()
  {
    // $this->router->run();
  }
}
