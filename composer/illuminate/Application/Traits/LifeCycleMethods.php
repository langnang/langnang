<?php

namespace Illuminate\Application\Traits;

trait LifeCycleMethods
{
  function _() {}

  function _init() {}

  function _log($text, $path = null)
  {
    $path = $path ?? $this->logPath;

    $handle = fopen($path, 'a');
    $text = empty($text) ? "\n" : "[" . date('Y-m-d h:i:s') . "] " . $text . "\n";

    fwrite($handle, $text);
    fclose($handle);
  }

  function _autoload(...$arguments)
  {
    foreach ($this->aliases as $alias => $illuminate) {
      if (method_exists($illuminate, __FUNCTION__)) {
        $this->_log(__METHOD__ . " \"$alias\"");
        $illuminate->{__FUNCTION__}(...$arguments);
      }
    }
    $this->_log(null);
  }


  function _run(...$arguments)
  {
    foreach ($this->aliases as $alias => $illuminate) {
      if (method_exists($illuminate, __FUNCTION__)) {
        $this->_log(__METHOD__ . " \"$alias\"");
        $illuminate->{__FUNCTION__}(...$arguments);
      }
    }
    $this->_log(null);
  }
}
