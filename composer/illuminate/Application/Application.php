<?php

namespace Illuminate\Application;


class Application
{
  public $alias = "app";

  public $aliases = [];

  // public $logs = [];

  use Traits\AbsolutePath;
  // use Traits\LifeCycleMethods;
  // use Traits\MagicMethods;

  public function __construct($basePath = null)
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
    foreach (\glob(dirname(__DIR__) . DIRECTORY_SEPARATOR . '*', GLOB_ONLYDIR) as $file) {

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

  public function __call($name, $arguments)
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
  private function _log($text, $path = null)
  {
    $path = $path ?? $this->logPath;

    $handle = fopen($path, 'a');
    $text = empty($text) ? "\n" : "[" . date('Y-m-d h:i:s') . "] " . $text . "\n";

    fwrite($handle, $text);
    fclose($handle);
  }
  private function _autoload(...$arguments)
  {
    foreach ($this->aliases as $alias => $illuminate) {
      if (method_exists($illuminate, __FUNCTION__)) {
        $this->_log(__METHOD__ . " \"$alias\"");
        $illuminate->{__FUNCTION__}(...$arguments);
      }
    }
    // dump(config('app.aliases'));
    // foreach (config('app.aliases') ?? [] as $alias => $path) {
    //   $this->aliases[$alias] = $path;
    // }
    $this->_log(null);
  }
  private function _run(...$arguments)
  {
    foreach ($this->aliases as $alias => $illuminate) {
      if (method_exists($illuminate, __FUNCTION__)) {
        $this->_log(__METHOD__ . " \"$alias\"");
        $illuminate->{__FUNCTION__}(...$arguments);
      }
    }
    $this->_log(null);
  }
  function singleton() {}
}
