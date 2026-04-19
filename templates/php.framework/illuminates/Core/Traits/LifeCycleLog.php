<?php

namespace Illuminates\Core\Traits;

trait LifeCycleLog
{
  protected $logPath;

  public function setLogPath($path = null)
  {
    if (!isset($_SERVER['USER_UNIQUE'])) {
      $_SERVER['USER_UNIQUE'] = substr(md5(serialize([
        "USERDOMAIN" => $_SERVER["USERDOMAIN"] ?? '',
        "USERDOMAIN_ROAMINGPROFILE" => $_SERVER["USERDOMAIN_ROAMINGPROFILE"] ?? '',
        "USERNAME" => $_SERVER["USERNAME"] ?? '',
        "USERPROFILE" => $_SERVER["USERPROFILE"] ?? '',
        "HTTP_USER_AGENT" => $_SERVER["HTTP_USER_AGENT"] ?? '',
        "HTTP_SEC_CH_UA_PLATFORM" => $_SERVER['HTTP_SEC_CH_UA_PLATFORM'] ?? '',
      ])), 8, 16);
    }

    if (empty($path)) {
      // $path
      $path = $this->logPath("app." . date('Ymd') . '.' . $_SERVER['USER_UNIQUE'] . ".log");
    }

    $this->logPath = $path;

    // var_dump($this->logPath);
  }

  public function getLogPath()
  {
    return $this->logPath;
  }
  protected $_logs = [];

  public function getLogs($name = null)
  {
    return $this->_logs;
  }

  protected function _log($text = null, $path = null)
  {

    $log = debug_backtrace()[1];

    if (!isset($this->_logs["."])) $this->_logs["."] = [];

    if (!isset($this->_logs[$log['function']])) $this->_logs[$log['function']] = [];

    array_push($this->_logs[$log['function']], $text);

    $path = $path ?? $this->logPath;

    if (empty($path)) {
      return;
    }

    $prefix = "[" . date('Y-m-d h:i:s') . "] " . $log['class'] . "->" . $log['function'] . ":" . $log['line'];
    $handle = fopen($path, 'a');
    // var_dump(json_encode($text));
    $text = $prefix . (empty($text) ? "" : ": ") . $text . "\n";

    fwrite($handle, $text);
    fclose($handle);
  }

  protected function __callWithLog($name, $args = []) {}
}
