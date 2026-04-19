<?php

namespace Illuminates\Application\Traits;

trait MagicMethods
{
  /**
   * Summary of __construct
   */
  function __construct($basePath = null)
  {
    $this->_log(json_encode([$basePath]));
    // var_dump(__FILE__);
    // var_dump(__CLASS__);
    if ($basePath) {
      $this->setBasePath($basePath);
    }
    $this->setLogPath();
    $this->__call('_before', [__FUNCTION__]);


    $this->_log();

    // var_dump($_SERVER);
    // var_dump(debug_backtrace());


    // $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

    // if (file_exists($this->logPath)) unlink($this->logPath);

    // $this->_log($url . "\n");
    $this->_autoload();
    // $this->__callWithLog('_autoload');

    // load core modules

    // var_dump($this->_aliases);
    // load helpers
    // foreach ($cfg['supports'] as $support) {
    // require_once $support;
    // }
    // var_dump($this);
  }
  function __get($name)
  {
    // var_dump(__METHOD__, $name);
    // return $this->{$name};
  }

  function __set($name, $value)
  {
    // var_dump([__METHOD__, $name, $value]);
    $this->{$name} = $value;
  }

  function __isset($name)
  {
    var_dump(__METHOD__);
  }

  function __unset($name)
  {
    var_dump(__METHOD__);
  }
  function __call($name, $args = [])
  {
    if (!is_array($args)) $args = [$args];

    if (method_exists($this, $name)) {
      return $this->{$name}(...$args);
    }
    if (isset($this->aliases[$name])) {
      $illuminate = $this->aliases[$name];
      if (method_exists($illuminate, 'get')) {
        return $illuminate->{'get'}(...$args);
      }
    }
  }

  function __sleep()
  {
    var_dump(__METHOD__);
  }

  function __wakeup()
  {
    var_dump(__METHOD__);
  }

  function __serialize()
  {
    var_dump(__METHOD__);
  }

  function __toString()
  {
    var_dump(__METHOD__);
    return '';
  }

  function __invoke()
  {
    var_dump(__METHOD__);
  }

  function __clone()
  {
    var_dump(__METHOD__);
  }

  function __debugInfo()
  {
    // var_dump(__METHOD__);
  }
}
