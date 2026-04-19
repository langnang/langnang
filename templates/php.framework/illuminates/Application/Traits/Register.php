<?php

namespace Illuminates\Application\Traits;

trait Register
{
  /**
   * @name
   * @var array
   */
  private $aliases = [];
  /**
   * Summary of getAliases
   * @param mixed $name
   * @return array|mixed|object
   */
  public function getAliases($name = null)
  {
    if (!empty($name) && isset($alias[$name])) return $this->aliases[$name];
    return $this->aliases;
  }
  /**
   * @name
   * @var array
   */
  private $facades = [];
  /**
   * Summary of getFacades
   * @param mixed $name
   */
  public function getFacades($name = null)
  {
    if (!empty($name) && isset($facades[$name])) return $this->facades[$name];
    return $this->facades;
  }

  /**
   * Summary of register
   * @param mixed $abstract
   * @return void
   */
  public function register($abstract)
  {
    $this->_log($abstract);
    if (!class_exists($abstract)) {
      return;
    }
    if (new $abstract instanceof \Illuminates\Core\Illuminate) {
      $this->registerAlias($abstract);
    }
    if (new $abstract instanceof \Illuminates\Core\Facade) {
      $this->registerFacade($abstract);
    }
  }
  /**
   * 
   */
  protected function registerAlias($abstract)
  {
    $class = new $abstract($this);
    // $filename = pathinfo($abstract)['filename'] ?: null;
    $abstractExploded = explode("\\", $abstract);
    $filename = end($abstractExploded);
    if (empty($filename))
      return;
    // var_dump($class);

    if (isset($class->alias))
      $alias = $class->alias;
    else
      $alias = strtolower(preg_replace('/([a-z])([A-Z])/', '${1}-${2}', $filename));

    $class->name = $filename;
    $class->alias = $alias;

    $this->aliases[$alias] = $class;
    $this->_log("$alias => $abstract");
  }
  /**
   * 
   */
  protected function registerFacade($abstract)
  {
    // $filename = pathinfo($abstract)['filename'] ?: null;
    // var_dump($abstract);
    // var_dump(explode("\\", $abstract));
    $abstractExploded = explode("\\", $abstract);
    $filename = end($abstractExploded);
    if (empty($filename))
      return;
    $this->facades[$filename] = $abstract;
    \class_alias($abstract, $filename);
    $this->_log("$filename => $abstract");
  }
}
