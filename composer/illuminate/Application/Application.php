<?php

namespace Illuminate\Application;


class Application extends \Core\Illuminate
{
  public $name = 'Application';
  public $alias = "app";



  private $facades = [];
  private $plugins = [];

  // public $logs = [];
  use \Core\Traits\AliasesTrait;
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
      "HTTP_USER_AGENT" => $_SERVER["HTTP_USER_AGENT"] ?? '',
    ])), 8, 16) . ".log");

    // $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

    // if (file_exists($this->logPath)) unlink($this->logPath);

    // $this->_log($url . "\n");

    // load core modules
    foreach (\glob(dirname(__DIR__) . DIRECTORY_SEPARATOR . '*', GLOB_ONLYDIR) as $file) {

      $filename = pathinfo($file)['filename'];

      // if (in_array($filename, $_ENV['ILLUMINATE_IGNORES'] ?? [])) continue;

      // var_dump($this->basePath("storage" . DIRECTORY_SEPARATOR . "logs" . DIRECTORY_SEPARATOR . "startup.log"));
      // var_dump($filename);
      $className = "Illuminate\\$filename\\$filename";

      foreach (\glob($file . DIRECTORY_SEPARATOR . 'Facades' . DIRECTORY_SEPARATOR . '*.php') as $facade) {
        $facadeName = pathinfo($facade)['filename'];
        \class_alias("Illuminate\\$filename\Facades\\$facadeName", $facadeName);
        $this->facades[$facadeName] = "Illuminate\\$filename\Facades\\$facadeName";
        $this->_log(__METHOD__ . " Facade \"$facadeName\" ");
      }

      if ($className == __CLASS__) {
        $this->aliases[$this->alias] = new class {
          public $name = 'Application';
          public $alias = 'app';
        };
        continue;
      }

      if (!class_exists($className)) continue;
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
  protected function _log($text, $path = null)
  {
    $path = $path ?? $this->logPath;

    $handle = fopen($path, 'a');
    $text = empty($text) ? "\n" : "[" . date('Y-m-d h:i:s') . "] " . $text . "\n";

    fwrite($handle, $text);
    fclose($handle);
  }
  protected function _autoload(...$arguments)
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
  protected function _run(...$arguments)
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

  protected function _print(...$arguments)
  {
    echo '<style type="text/css">
      body {background-color: #fff; color: #222; font-family: sans-serif;}
      pre {margin: 0; font-family: monospace;}
      a:link {color: #009; text-decoration: none; background-color: #fff;}
      a:hover {text-decoration: underline;}
      table {border-collapse: collapse; border: 0; width: 1200px!important; box-shadow: 1px 2px 3px #ccc;}
      .center {text-align: center;}
      .center table {margin: 1em auto; text-align: left;}
      .center th {text-align: center !important;}
      td, th {border: 1px solid #666; font-size: 75%; vertical-align: baseline; padding: 4px 5px;}
      h1 {font-size: 150%;}
      h2 {font-size: 125%;}
      .p {text-align: left;}
      .e {background-color: #ccf; width: 300px; font-weight: bold;}
      .h {background-color: #99c; font-weight: bold;}
      .v {background-color: #ddd; max-width: 300px; overflow-x: auto; word-wrap: break-word;}
      .v i {color: #999;}
      img {float: right; border: 0;}
      hr {width: 934px; background-color: #ccc; border: 0; height: 1px;}
      </style>';
    echo '<div class="center">';

    echo '<table>
      <tbody><tr class="h"><td>
      <a href="http://www.php.net/"><img border="0" src="data:image/png;base64,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" alt="PHP logo"></a><h1 class="p">PHP Version ' . phpversion() . '</h1>
      </td></tr>
      </tbody></table>';

    // phpcredits(CREDITS_ALL);

    echo  '<h1> PHP Server </h1>';
    echo "<table><tbody>";
    foreach ($_SERVER as $key => $value) {
      if ($key == 'Path') $value = implode(";<br/>", explode(";", $value));
      echo "<tr><td class=\"e\">$key</td><td class=\"v\">$value</td><td class=\"v\"></td></tr>";
    }
    echo "</tbody></table>";

    echo  '<h1> User Function </h1>';
    echo "<table><tbody>";
    foreach (get_defined_functions()['user'] as $alias => $method) {
      echo "<tr><td class=\"e\">$method</td><td class=\"v\"></td><td class=\"v\"></td></tr>";
    }
    echo "</tbody></table>";
    unset($alias, $method);
    // var_dump(get_defined_functions(false));

    echo  '<h1> Illuminates </h1>';

    parent::{__FUNCTION__}(...$arguments);

    // aliases
    echo "<table><tbody>";
    // echo '<tr class="h"><th>memcache support</th><th>enabled</th></tr>';
    echo '<tr class="h"><th colspan="2"> Aliases </th><th> Annotation </th></tr>';
    foreach ($this->aliases as $alias => $illuminate) {
      echo "<tr><td class=\"e\">$illuminate->name</td><td class=\"v\">$alias</td><td class=\"v\"></td></tr>";
    }
    unset($alias, $illuminate);
    echo "</tbody></table>";
    // facades
    echo "<table><tbody>";
    echo '<tr class="h"><th colspan="2"> Facades </th><th> Annotation </th></tr>';
    foreach ($this->facades as $alias => $facade) {
      echo "<tr><td class=\"e\">$alias</td><td class=\"v\">$facade</td><td class=\"v\"></td></tr>";
    }
    unset($alias, $illuminate);
    echo "</tbody></table>";

    foreach ($this->aliases as $alias => $illuminate) {
      if (method_exists($illuminate, __FUNCTION__)) {
        $illuminate->{__FUNCTION__}(...$arguments);
      }
    }
    unset($alias, $illuminate);

    echo  '<h1> Configuration </h1>';
    $extensions = get_loaded_extensions();
    foreach ($extensions as $extension) {
      echo "<a href='#Configuration.$extension'><h2 id='Configuration.$extension'>" . $extension . "</h2></a>";
      // methods
      echo "<table><tbody>";
      echo '<tr class="h"><th colspan="2"> Methods </th><th> Annotation </th></tr>';

      // echo '<td class="e">' . implode(", ", get_extension_funcs($extension) ?: [])  . '</td>';
      foreach (get_extension_funcs($extension) ?: [] as $alias => $method) {
        echo "<tr><td class=\"e\">$method</td><td class=\"v\"></td><td class=\"v\"></td></tr>";
      }
      // foreach (array_values($methods) as $alias => $method) {
      //   if (preg_match("/^_/", $method)) continue;
      //   echo "<tr><td class=\"e\">$alias</td><td class=\"v\">$method</td></tr>";
      // }
      // unset($methods, $alias, $method);
      echo "</tbody></table>";
    }
    unset($extensions, $extension, $alias, $method);
    echo "</div>";
  }

  function get($name = null)
  {
    if (empty($name)) return $this;
    return $this->aliases[$name];
  }
  private function load_illuminates() {}
  private function load_plugins() {}
  private function load_facades() {}
}
