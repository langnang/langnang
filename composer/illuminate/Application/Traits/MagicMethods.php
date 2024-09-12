<?php

namespace Illuminate\Application\Traits;

trait MagicMethods
{
  function __construct($basePath = null)
  {
    // var_dump(__FILE__);
    // var_dump(__CLASS__);
    if ($basePath) {
      $this->setBasePath($basePath);
    }
    // var_dump($_SERVER);
    // var_dump(debug_backtrace());
    $this->logPath = $this->logPath("app." . date('Ymd') . '.' . substr(md5(serialize([
      "USERDOMAIN" => $_SERVER["USERDOMAIN"],
      "USERDOMAIN_ROAMINGPROFILE" => $_SERVER["USERDOMAIN_ROAMINGPROFILE"],
      "USERNAME" => $_SERVER["USERNAME"],
      "USERPROFILE" => $_SERVER["USERPROFILE"],
      "HTTP_USER_AGENT" => $_SERVER["HTTP_USER_AGENT"],
    ])), 8, 16) . ".log");

    $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

    // if (file_exists($this->logPath)) unlink($this->logPath);

    $this->_log($url . "\n");

    // load core modules
    foreach (\glob(dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . '*', GLOB_ONLYDIR) as $file) {

      $filename = pathinfo($file)['filename'];

      if (in_array($filename, $_ENV['ILLUMINATE_IGNORES'] ?? [])) continue;

      // var_dump($this->basePath("storage" . DIRECTORY_SEPARATOR . "logs" . DIRECTORY_SEPARATOR . "startup.log"));
      // var_dump($filename);
      $className = "Illuminate\\$filename\\$filename";

      foreach (\glob($file . DIRECTORY_SEPARATOR . 'Facades' . DIRECTORY_SEPARATOR . '*.php') as $facade) {
        $facadeName = pathinfo($facade)['filename'];
        \class_alias("Illuminate\\$filename\Facades\\$facadeName", $facadeName);
        $this->_log(__METHOD__ . " Facade \"$facadeName\" ");
      }

      if ($className == __CLASS__) {
        $this->aliases[$this->alias] = new class {
          public $name = 'Application';
          public $alias = 'app';
        };
        continue;
      }

      $class = new $className;
      // var_dump($class);

      if (isset($class->alias)) $alias = $class->alias;
      else $alias = strtolower(preg_replace('/([a-z])([A-Z])/', '${1}-${2}', $filename));

      $class->name = $filename;
      $class->alias = $alias;

      $this->aliases[$alias] = $class;
      $this->_log(__METHOD__ . " \"$alias\" => \"$className\"");

      // array_push($this->_aliases, $alias);

      // $this->{$alias} = $class;
      // var_dump($class);
    }
    $this->_log(null);
    // var_dump($this->_aliases);
    // load helpers
    // foreach ($cfg['supports'] as $support) {
    // require_once $support;
    // }
  }

  function __call($name, $arguments)
  {
    if (method_exists($this, $name)) {
      return $this->{$name}(...$arguments);
    }
    if (isset($this->aliases[$name])) {
      $illuminate = $this->aliases[$name];
      if (method_exists($illuminate, 'get')) {
        return $illuminate->{'get'}(...$arguments);
      }
    }
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
