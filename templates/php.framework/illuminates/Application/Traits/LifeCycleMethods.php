<?php

namespace Illuminates\Application\Traits;

trait LifeCycleMethods
{
  protected function _() {}

  protected function _init() {}
  protected function _call($method, ...$args)
  {
    foreach ($this->aliases as $alias => $illuminate) {
      if (method_exists($illuminate, $method)) {
        $this->_log(get_class($illuminate) . "::" . $method);
        $illuminate->{$method}($args);
      }
    }
  }
  protected function _run(...$args)
  {
    $this->_call(__FUNCTION__, ...$args);
  }
  protected function _before($method, ...$args)
  {
    // var_dump(__METHOD__);
  }
  protected function _after($method, ...$args)
  {
    // var_dump(__METHOD__);
  }
  protected function _autoload()
  {
    $this->_log();
    foreach (\glob(dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . '*', GLOB_ONLYDIR) as $file) {

      $filename = pathinfo($file)['filename'];

      // if (in_array($filename, $_ENV['ILLUMINATE_IGNORES'] ?? [])) continue;

      // var_dump($this->basePath("storage" . DIRECTORY_SEPARATOR . "logs" . DIRECTORY_SEPARATOR . "startup.log"));
      // var_dump($filename);
      $className = "Illuminates\\$filename\\$filename";

      if ($className !== __CLASS__) {
        $this->__call('register', $className);
      }

      // var_dump($filename, $className);
      foreach (\glob($file . DIRECTORY_SEPARATOR . 'Facades' . DIRECTORY_SEPARATOR . '*.php') as $facade) {
        $facadeName = pathinfo($facade)['filename'];
        // \class_alias("Illuminates\\$filename\Facades\\$facadeName", $facadeName);
        $facadeClass = "Illuminates\\$filename\Facades\\$facadeName";
        $this->__call('register', $facadeClass);
        // $this->facades[$facadeName] = "Illuminates\\$filename\Facades\\$facadeName";
        // $this->_log(__METHOD__ . " Facade \"$facadeName\" ");
      }
    }
  }
}
