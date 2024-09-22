<?php

namespace Core\Traits;

trait AliasesTrait
{
  private $aliases = [];
  /**
   * set
   */
  function set_aliases($name, $value = null)
  {
    if (!is_array($this->aliases)) $this->aliases = [];
    $this->aliases[$name] = $value;
  }
  /**
   * get
   */
  function get_aliases($name = null)
  {
    if (empty($this->aliases)) return;
    return empty($name) ? $this->aliases : $this->aliases[$name];
  }
  /**
   * is
   */
  /**
   * isset
   */
  /**
   * unset
   */
  /**
   * has
   */
  /**
   * exists
   */
  function alias_exists($name)
  {
    return array_key_exists($name, $this->aliases);
  }
  /**
   * to
   */
}
