<?php

namespace Illuminates\Application;

/**
 * 
 * @var name
 * @var alias
 * @var facades
 * @var plugins
 * 
 * @method __construct
 * @method __call
 * 
 * @method _init
 * @method _autoload
 * @method _log
 * 
 * @method get
 * @method make
 * @method register
 * @method sigleton
 * @method get		
 * @method make		
 * @method register		
 * @method singleton		
 * @method singletonIf		
 * @method flush		
 * @method set_aliases		
 * @method get_aliases		
 * @method alias_exists		
 * @method path		
 * @method setBasePath		
 * @method resourcePath		
 * @method basePath		
 * @method databasePath		
 * @method publicPath		
 * @method langPath		
 * @method configPath		
 * @method storagePath		
 * @method logPath		
 * @method set_facades		
 * @method get_facades		
 * @method facade_exists
 */
class Application
{
  /**
   * @name
   * @var string
   */
  public $name = 'Application';
  /**
   * @name
   * @var string
   */
  public $alias = "app";

  /**
   * @name 
   * @var array
   * @
   */
  private $plugins = [];


  // public $logs = [];
  use \Illuminates\Core\Traits\AliasesTrait;
  use \Illuminates\Core\Traits\LifeCycleLog;
  use Traits\AbsolutePath;
  use Traits\FacadesTrait;
  use Traits\LifeCycleMethods;
  use Traits\LifeCycleMethods;
  use Traits\MagicMethods;
  use Traits\Register;

  function get($name = null)
  {
    if (empty($name))
      return $this;
    return $this->aliases[$name];
  }

  /**
   * Resolve the given type from the container.
   * 从容器中解析给定的类型
   */
  public function make($abstract, $value = null)
  {

    if (class_exists($abstract)) {
      if ($abstract instanceof \Illuminates\Core\Illuminate) {
      } else if ($abstract instanceof \Illuminates\Core\Facade) {
      }
      // print_r($aliasOrClass);
      $class = new $abstract;
      $filename = pathinfo($abstract)['filename'];
      // var_dump($class);

      if (isset($class->alias))
        $alias = $class->alias;
      else
        $alias = strtolower(preg_replace('/([a-z])([A-Z])/', '${1}-${2}', $filename));

      $class->name = $filename;
      $class->alias = $alias;

      $this->aliases[$alias] = $class;
      return $class;
    } else {
      $this->aliases[$abstract] = $value;
    }
  }

  /**
   * Register a shared binding in the container.
   *
   * @param  string  $abstract
   * @param  \Closure|string|null  $concrete
   * @return void
   */
  public function singleton($abstract, $concrete = null) {}
  /**
   * Register a shared binding if it hasn't already been registered.
   *
   * @param  string  $abstract
   * @param  \Closure|string|null  $concrete
   * @return void
   */
  public function singletonIf($abstract, $concrete = null) {}
}
