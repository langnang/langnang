<?php

namespace Illuminates\Core\Contracts;

interface MagicMethods
{
  // function __construct();

  function __set($name, $value = null);

  function __get($name);
}
