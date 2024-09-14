<?php

namespace Illuminate\Str;

class Stringable
{
  public $value;

  function __construct($value)
  {
    $this->value = $value;
  }
}
