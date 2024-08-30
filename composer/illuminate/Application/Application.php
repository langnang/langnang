<?php

namespace Illuminate\Application;


class Application
{
  public $alias = "app";

  public $aliases = [];

  use Traits\AbsolutePath;
  use Traits\LifeCycleMethods;
  use Traits\MagicMethods;

  function singleton() {}
}
