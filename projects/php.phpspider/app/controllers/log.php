<?php
// +----------------------------------------------------------------------
// | PHPSpider [ A PHP Framework For Crawler ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2014 https://doc.phpspider.org All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: Seatle Yang <seatle@foxmail.com>
// +----------------------------------------------------------------------

//----------------------------------
// PHPSpider日志类文件
//----------------------------------

namespace app\controllers;

class log
{
  public static $log_show = false;
  public static $log_type = false;
  public static $log_file = "data/phpspider.log";
  public static $out_sta = "";
  public static $out_end = "";

  public static function note($msg)
  {
    self::$out_sta = self::$out_end = "";
    self::msg($msg, 'note');
  }

  public static function info($msg)
  {
    self::$out_sta = self::$out_end = "";
    self::msg($msg, 'info');
  }
  public static function step($msg, $depth = 0)
  {
    self::$out_sta = self::$out_end = "";
    if (!util::is_win()) {
      self::$out_sta = "\033[35m";
      self::$out_end = "\033[0m";
    } else {
      self::$out_sta = "\033[35m";
      self::$out_end = "\033[0m";
    }

    self::msg($msg, 'step', str_pad('🟣', 4 + $depth, " "));
  }
  public static function warn($msg)
  {
    self::$out_sta = self::$out_end = "";
    if (!util::is_win()) {
      self::$out_sta = "\033[33m";
      self::$out_end = "\033[0m";
    } else {
      self::$out_sta = "\033[33m";
      self::$out_end = "\033[0m";
    }

    self::msg($msg, 'warn', '🟡');
  }

  public static function success($msg)
  {
    self::$out_sta = self::$out_end = "";
    if (!util::is_win()) {
      self::$out_sta = "\033[36m";
      self::$out_end = "\033[0m";
    } else {
      self::$out_sta = "\033[36m";
      self::$out_end = "\033[0m";
    }

    self::msg($msg, 'success', '🟢');
  }

  public static function debug($msg)
  {
    self::$out_sta = self::$out_end = "";
    if (!util::is_win()) {
      self::$out_sta = "\033[34m";
      self::$out_end = "\033[0m";
    } else {
      self::$out_sta = "\033[34m";
      self::$out_end = "\033[0m";
    }

    self::msg($msg, 'debug', '🔵');
  }

  public static function error($msg)
  {
    self::$out_sta = self::$out_end = "";
    if (!util::is_win()) {
      self::$out_sta = "\033[31m";
      self::$out_end = "\033[0m";
    } else {
      self::$out_sta = "\033[31m";
      self::$out_end = "\033[0m";
    }

    self::msg($msg, 'error', "🔴");
  }

  public static function msg($msg, $log_type, $log_ico = "⚪")
  {
    if ($log_type != 'note' && self::$log_type && strpos(self::$log_type, $log_type) === false) {
      return false;
    }

    if (is_array($msg)) {
      $msg = json_encode($msg, JSON_UNESCAPED_UNICODE);
    }

    if ($log_type == 'note') {
      $msg = self::$out_sta . $msg . "\n" . self::$out_end;
    } else {
      $msg = self::$out_sta . date("Y-m-d H:i:s") . str_pad(" [{$log_type}]", 10, " ") . " {$log_ico} " . $msg . self::$out_end . "\n";
    }
    if (self::$log_show) {
      echo $msg;
    }
    file_put_contents(self::$log_file, $msg, FILE_APPEND | LOCK_EX);
  }

  /**
   * 记录日志 XXX
   * @param string $msg
   * @param string $log_type  Note|Warning|Error
   * @return void
   */
  public static function add($msg, $log_type = '')
  {
    if ($log_type != '') {
      $msg = date("Y-m-d H:i:s") . " [{$log_type}] " . $msg . "\n";
    }
    if (self::$log_show) {
      echo $msg;
    }
    //file_put_contents(PATH_DATA."/log/".strtolower($log_type).".log", $msg, FILE_APPEND | LOCK_EX);
    file_put_contents(PATH_DATA . "/log/error.log", $msg, FILE_APPEND | LOCK_EX);
  }
}
