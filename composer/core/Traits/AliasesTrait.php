<?php

namespace Core\Traits;

trait AliasesTrait
{
  function get_aliases($name = null)
  {
    if (empty($this->aliases)) return;
    return empty($name) ? $this->aliases : $this->aliases[$name];
  }

  function alias_exists($name)
  {
    return array_key_exists($name, $this->aliases);
  }
}
