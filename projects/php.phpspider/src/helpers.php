<?php

function _e($values)
{
  echo $values;
}

function get_ascii_art()
{
  return ""
    . "    ____  __         _____       _     __         " . PHP_EOL
    . "   / __ \/ /_  ____ / ___/____  (_)___/ /__  _____" . PHP_EOL
    . "  / /_/ / __ \/ __ \\__ \/ __ \/ / __  / _ \/ ___/" . PHP_EOL
    . " / ____/ / / / /_/ /__/ / /_/ / / /_/ /  __/ /    " . PHP_EOL
    . "/_/   /_/ /_/ .___/____/ .___/_/\__,_/\___/_/     " . PHP_EOL
    . "           /_/        /_/                         " . PHP_EOL;
}


function html_to_markdown($html) {}


function env($key, $default = null)
{
  global $_ENV;
  return array_get($_ENV, $key, $default);
}

function app_path() {}
function storage_path($path)
{
  return __DIR__
    . (str_ends_with(env('STORAGE_PATH'), '/') ? substr(env('STORAGE_PATH'), 0, -1) : env('STORAGE_PATH'))
    . str_start($path, '/');
}
function config_path($path) {}
function cache_path($path) {}
function log_path($path) {}
/**
 * Array
 * Arr::accessible
Arr::add
Arr::collapse
Arr::crossJoin
Arr::divide
Arr::dot
Arr::except
Arr::exists
Arr::first
Arr::flatten
Arr::forget
Arr::get
Arr::has
Arr::hasAny
Arr::isAssoc
Arr::last
Arr::only
Arr::pluck
Arr::prepend
Arr::pull
Arr::query
Arr::random
Arr::set
Arr::shuffle
Arr::sort
Arr::sortRecursive
Arr::where
Arr::wrap
data_fill
data_get
data_set
head
last
 */
function array_get($array, $key, $default = null)
{
  if (is_null($key)) {
    return $array;
  }

  if (isset($array[$key])) {
    return $array[$key];
  }

  foreach (explode('.', $key) as $segment) {
    if (!is_array($array) || ! array_key_exists($segment, $array)) {
      return $default;
    }

    $array = $array[$segment];
  }
  return $array;
}
function array_set(array &$array, $key, $value = null)
{
  if (is_null($key)) {
    return $array;
  }


  $explode_key = explode('.', $key);
  if (sizeof($explode_key) == 1) {
    $array[$key] = $value;
  } else {
    if (!array_key_exists($explode_key[0], $array)) {
      $array[$explode_key[0]] = [];
    }
    // var_dump(implode(".", array_slice($explode_key, 1)));
    array_set($array[$explode_key[0]], implode(".", array_slice($explode_key, 1)), $value);
  }
  return $array;

  if (array_key_exists($explode_key[0], $array)) {
    $array[$explode_key[0]] = array_set([], implode(".", array_slice($explode_key, 1), $value));
  }
  if (sizeof($explode_key) > 1) {
  }
  var_dump($array);
  return $array;

  $depth = $array;
  foreach (explode('.', $key) as $index => $segment) {
    var_dump($segment);
    // var_dump($depth[$segment]);

    // if (is_array($array)) {
    // }
    // if (!is_array($array) || ! array_key_exists($segment, $array)) {
    //   // return $default;
    // }

    // $array = $array[$segment];
  }
  $i = 0;
  $return = array_reduce(explode('.', $key), function (&$carry, $item) use (&$i, $key) {
    if (!array_key_exists($item, $carry)) {
      $carry[$item] = [];
    }
    $i++;
    return $carry;
  }, []);
  var_dump($i);
  var_dump($return);
  return $array;
}
function array_deep_merge($array1, $array2)
{
  foreach ($array2 as $key => $value) {
    if (array_key_exists($key, $array1)) {
      if (is_array($value) && is_array($array1[$key])) {
        $array1[$key] = array_deep_merge($array1[$key], $value);
      } else {
        $array1[$key] = $value;
      }
    } else {
      $array1[$key] = $value;
    }
  }
  return $array1;
}
/**
 * String
 * __
class_basename
e
preg_replace_array
Str::after
Str::afterLast
Str::ascii
Str::before
Str::beforeLast
Str::between
Str::camel
Str::contains
Str::containsAll
Str::endsWith
Str::finish
Str::is
Str::isAscii
Str::isUuid
Str::kebab
Str::length
Str::limit
Str::lower
Str::orderedUuid
Str::padBoth
Str::padLeft
Str::padRight
Str::plural
Str::random
Str::replaceArray
Str::replaceFirst
Str::replaceLast
Str::singular
Str::slug
Str::snake
Str::start
Str::startsWith
Str::studly
Str::substr
Str::title
Str::ucfirst
Str::upper
Str::uuid
Str::words
trans
trans_choice

after
afterLast
append
ascii
basename
before
beforeLast
camel
contains
containsAll
dirname
endsWith
exactly
explode
finish
is
isAscii
isEmpty
isNotEmpty
kebab
length
limit
lower
ltrim
match
matchAll
padBoth
padLeft
padRight
plural
prepend
replace
replaceArray
replaceFirst
replaceLast
replaceMatches
rtrim
singular
slug
snake
split
start
startsWith
studly
substr
title
trim
ucfirst
upper
when
whenEmpty
words
 */

/**
 * Checks if $needle is found in $haystack and returns a boolean value
 * (true/false) whether or not the $needle was found.
 *
 * @param string $haystack
 * @param string $needle
 * @return bool
 * @since 8.0
 */
function str_contains(string $haystack, string $needle): bool
{
  return strpos($haystack, $needle) !== false;
}
function str_end(string $haystack, string $needle): string
{
  if (str_ends_with($haystack, $needle)) return $haystack;
  return $haystack . $needle;
}
function str_ends_with(string $haystack, string $needle): bool
{
  return substr($haystack, -strlen($needle)) === $needle;
}
function str_start(string $haystack, string $needle): string
{
  if (str_starts_with($haystack, $needle)) return $haystack;
  return $needle . $haystack;
}
function str_starts_with(string $haystack, string $needle): bool
{
  return substr($haystack, 0, strlen($needle)) === $needle;
}
/**
 * 
 * abort
abort_if
abort_unless
app
auth
back
bcrypt
blank
broadcast
cache
class_uses_recursive
collect
config
cookie
csrf_field
csrf_token
dd
dispatch
dispatch_now
dump
env
event
filled
info
logger
method_field
now
old
optional
policy
redirect
report
request
rescue
resolve
response
retry
session
tap
throw_if
throw_unless
today
trait_uses_recursive
transform
validator
value
view
with

 * 
 */


/**
 * Util
 */

/**
 * 文件锁
 * 如果没有锁，就加一把锁并且执行逻辑，然后删除锁
 * if (!util::lock('statistics_offer'))
 * {
 *     util::lock('statistics_offer');
 *     ...
 *     util::unlock('statistics_offer');
 * }
 * 否则输出锁存在
 * else
 * {
 *     echo "process has been locked\n";
 * }
 * 
 * @param mixed $lock_name
 * @param int $lock_timeout
 * @return void
 * @author seatle <seatle@foxmail.com> 
 * @created time :2016-02-18 14:28
 */
function lock($lock_name, $lock_timeout = 600)
{
  $lock = get_file(PATH_DATA . "/lock/{$lock_name}.lock");
  if ($lock) {
    $time = time() - $lock;
    // 还没到10分钟，说明进程还活着
    if ($time < $lock_timeout) {
      return true;
    }
    unlink(PATH_DATA . "/lock/{$lock_name}.lock");
  }
  put_file(PATH_DATA . "/lock/{$lock_name}.lock", time());
  return false;
}

function unlock($lock_name)
{
  unlink(PATH_DATA . "/lock/{$lock_name}.lock");
}

function time2second($time, $is_log = true)
{
  if (is_numeric($time)) {
    $value = array(
      "years" => 0,
      "days" => 0,
      "hours" => 0,
      "minutes" => 0,
      "seconds" => 0,
    );
    if ($time >= 31556926) {
      $value["years"] = floor($time / 31556926);
      $time = ($time % 31556926);
    }
    if ($time >= 86400) {
      $value["days"] = floor($time / 86400);
      $time = ($time % 86400);
    }
    if ($time >= 3600) {
      $value["hours"] = floor($time / 3600);
      $time = ($time % 3600);
    }
    if ($time >= 60) {
      $value["minutes"] = floor($time / 60);
      $time = ($time % 60);
    }
    $value["seconds"] = floor($time);
    //return (array) $value;
    //$t = $value["years"] ."y ". $value["days"] ."d ". $value["hours"] ."h ". $value["minutes"] ."m ".$value["seconds"]."s";
    if ($is_log) {
      $t = $value["days"] . "d " . $value["hours"] . "h " . $value["minutes"] . "m " . $value["seconds"] . "s";
    } else {
      $t = $value["days"] . " days " . $value["hours"] . " hours " . $value["minutes"] . " minutes";
    }
    return $t;
  } else {
    return false;
  }
}

function get_days($day_sta, $day_end = true, $range = 86400)
{
  if ($day_end === true) $day_end = date('Y-m-d');

  return array_map(function ($time) {
    return date('Y-m-d', $time);
  }, range(strtotime($day_sta), strtotime($day_end), $range));
}

/**
 * 获取文件行数
 * 
 * @param mixed $filepath
 * @return void
 * @author seatle <seatle@foxmail.com> 
 * @created time :2016-03-31 21:54
 */
function get_file_line($filepath)
{
  $line = 0;
  $fp = fopen($filepath, 'r');
  if (!$fp) {
    return 0;
  }
  //获取文件的一行内容，注意：需要php5才支持该函数；
  while (stream_get_line($fp, 8192, "\n")) {
    $line++;
  }
  fclose($fp); //关闭文件
  return $line;
}

/**
 * 获得表数
 * 
 * @param mixed $table_name     表名
 * @param mixed $item_value     唯一索引
 * @param int $table_num        表数量
 * @return void
 * @author seatle <seatle@foxmail.com> 
 * @created time :2015-10-22 23:25
 */
function get_table_num($item_value, $table_num = 100)
{
  //sha1:返回一个40字符长度的16进制数字
  $item_value = sha1(strtolower($item_value));
  //base_convert:进制建转换，下面是把16进制转成10进制，方便做除法运算
  //str_pad:把字符串填充为指定的长度，下面是在左边加0，表数量大于100就3位，否则2位
  $step = $table_num > 100 ? 3 : 2;
  $item_value = str_pad(base_convert(substr($item_value, -2), 16, 10) % $table_num, $step, "0", STR_PAD_LEFT);
  return $item_value;
}

/**
 * 获得表面
 * 
 * @param mixed $table_name     表名
 * @param mixed $item_value     唯一索引
 * @param int $table_num        表数量
 * @return void
 * @author seatle <seatle@foxmail.com> 
 * @created time :2015-10-22 23:25
 */
function get_table_name($table_name, $item_value, $table_num = 100)
{
  //sha1:返回一个40字符长度的16进制数字
  $item_value = sha1(strtolower($item_value));
  //base_convert:进制建转换，下面是把16进制转成10进制，方便做除法运算
  //str_pad:把字符串填充为指定的长度，下面是在左边加0，共3位
  $step = $table_num > 100 ? 3 : 2;
  $item_value = str_pad(base_convert(substr($item_value, -2), 16, 10) % $table_num, $step, "0", STR_PAD_LEFT);
  return $table_name . "_" . $item_value;
}

// 获得当前使用内存
// function memory_get_usage()
// {
//   $memory = memory_get_usage();
//   return format_bytes($memory);
// }

// 获得最高使用内存
// function memory_get_peak_usage()
// {
//   $memory = memory_get_peak_usage();
//   return format_bytes($memory);
// }

// 转换大小单位
function format_bytes($size)
{
  $unit = array('b', 'kb', 'mb', 'gb', 'tb', 'pb');
  $i = floor(log($size, 1024));
  return @round($size / pow(1024, (floor(log($size, 1024)))), 2) . ' ' . $unit[$i];
}

/**
 * 获取数组大小
 *
 * @param mixed $arr 数组
 * @return string
 */
function array_size($arr)
{
  ob_start();
  // print_r($arr);
  $mem = ob_get_contents();
  ob_end_clean();
  $mem = preg_replace("/\n +/", "", $mem);
  $mem = strlen($mem);
  return format_bytes($mem);
}

/**
 * 数字随机数
 * 
 * @param int $num
 * @return void
 * @author seatle <seatle@foxmail.com> 
 * @created time :2016-09-18 10:17
 */
function rand_num($num = 7)
{
  $rand = "";
  for ($i = 0; $i < $num; $i++) {
    $rand .= mt_rand(0, 9);
  }
  return $rand;
}

/**
 * 字母数字混合随机数
 * 
 * @param int $num
 * @return void
 * @author seatle <seatle@foxmail.com> 
 * @created time :2016-09-18 10:17
 */
function rand_str($num = 10)
{
  $chars = 'abcdefghijklmnopqrstuvwxyz0123456789';
  $string = "";
  for ($i = 0; $i < $num; $i++) {
    $string .= substr($chars, rand(0, strlen($chars)), 1);
  }
  return $string;
}

/**
 * 汉字转拼音
 *
 * @param mixed $str 汉字
 * @param int $ishead
 * @param int $isclose
 * @static
 * @access public
 * @return string
 */
function pinyin($str, $ishead = 0, $isclose = 1)
{
  // $str = iconv("utf-8", "gbk//ignore", $str);
  $str = mb_convert_encoding($str, "gbk", "utf-8");
  global $pinyins;
  $restr = '';
  $str = trim($str);
  $slen = strlen($str);
  if ($slen < 2) {
    return $str;
  }
  if (count($pinyins) == 0) {
    $fp = fopen(PATH_DATA . '/pinyin.dat', 'r');
    while (!feof($fp)) {
      $line = trim(fgets($fp));
      $pinyins[$line[0] . $line[1]] = substr($line, 3, strlen($line) - 3);
    }
    fclose($fp);
  }
  for ($i = 0; $i < $slen; $i++) {
    if (ord($str[$i]) > 0x80) {
      $c = $str[$i] . $str[$i + 1];
      $i++;
      if (isset($pinyins[$c])) {
        if ($ishead == 0) {
          $restr .= $pinyins[$c];
        } else {
          $restr .= $pinyins[$c][0];
        }
      } else {
        // $restr .= "_";
      }
    } else if (preg_match("/[a-z0-9]/i", $str[$i])) {
      $restr .= $str[$i];
    } else {
      // $restr .= "_";
    }
  }
  if ($isclose == 0) {
    unset($pinyins);
  }
  return $restr;
}

/**
 * 生成字母前缀
 * 
 * @param mixed $s0
 * @return char
 * @author seatle <seatle@foxmail.com> 
 * @created time :2016-09-18 10:17
 */
function letter_first($s0)
{
  $firstchar_ord = ord(strtoupper($s0[0]));
  if (($firstchar_ord >= 65 and $firstchar_ord <= 91) or ($firstchar_ord >= 48 and $firstchar_ord <= 57)) return $s0[0];
  // $s = iconv("utf-8", "gbk//ignore", $s0);
  $s = mb_convert_encoding($s0, "gbk", "utf-8");
  $asc = ord($s[0]) * 256 + ord($s[1]) - 65536;
  if ($asc >= -20319 and $asc <= -20284) return "A";
  if ($asc >= -20283 and $asc <= -19776) return "B";
  if ($asc >= -19775 and $asc <= -19219) return "C";
  if ($asc >= -19218 and $asc <= -18711) return "D";
  if ($asc >= -18710 and $asc <= -18527) return "E";
  if ($asc >= -18526 and $asc <= -18240) return "F";
  if ($asc >= -18239 and $asc <= -17923) return "G";
  if ($asc >= -17922 and $asc <= -17418) return "H";
  if ($asc >= -17417 and $asc <= -16475) return "J";
  if ($asc >= -16474 and $asc <= -16213) return "K";
  if ($asc >= -16212 and $asc <= -15641) return "L";
  if ($asc >= -15640 and $asc <= -15166) return "M";
  if ($asc >= -15165 and $asc <= -14923) return "N";
  if ($asc >= -14922 and $asc <= -14915) return "O";
  if ($asc >= -14914 and $asc <= -14631) return "P";
  if ($asc >= -14630 and $asc <= -14150) return "Q";
  if ($asc >= -14149 and $asc <= -14091) return "R";
  if ($asc >= -14090 and $asc <= -13319) return "S";
  if ($asc >= -13318 and $asc <= -12839) return "T";
  if ($asc >= -12838 and $asc <= -12557) return "W";
  if ($asc >= -12556 and $asc <= -11848) return "X";
  if ($asc >= -11847 and $asc <= -11056) return "Y";
  if ($asc >= -11055 and $asc <= -10247) return "Z";
  return 0; // null
}

/**
 * 获得某天前的时间戳
 * 
 * @param mixed $day
 * @return void
 * @author seatle <seatle@foxmail.com> 
 * @created time :2016-09-18 10:17
 */
function getxtime($day)
{
  $day = intval($day);
  return mktime(23, 59, 59, date("m"), date("d") - $day, date("y"));
}

/**
 * 读文件
 */
function get_file($url, $timeout = 10)
{
  if (function_exists('curl_init')) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    $content = curl_exec($ch);
    curl_close($ch);
    if ($content) return $content;
  }
  $ctx = stream_context_create(array('http' => array('timeout' => $timeout)));
  $content = @file_get_contents($url, 0, $ctx);
  if ($content) return $content;
  return false;
}

/**
 * 写文件，如果文件目录不存在，则递归生成
 */
function put_file($file, $content, $flag = 0)
{
  $pathinfo = pathinfo($file);
  if (!empty($pathinfo['dirname'])) {
    if (file_exists($pathinfo['dirname']) === false) {
      if (@mkdir($pathinfo['dirname'], 0777, true) === false) {
        return false;
      }
    }
  }
  if ($flag === FILE_APPEND) {
    // 多个php-fpm写一个文件的时候容易丢失，要加锁
    //return @file_put_contents($file, $content, FILE_APPEND|LOCK_EX);
    return @file_put_contents($file, $content, FILE_APPEND);
  } else {
    return @file_put_contents($file, $content, LOCK_EX);
  }
}

/**
 * 检查路径是否存在,不存在则递归生成路径
 *
 * @param mixed $path 路径
 * @static
 * @access public
 * @return bool or string
 */
function path_exists($path)
{
  $pathinfo = pathinfo($path . '/tmp.txt');
  if (!empty($pathinfo['dirname'])) {
    if (file_exists($pathinfo['dirname']) === false) {
      if (mkdir($pathinfo['dirname'], 0777, true) === false) {
        return false;
      }
    }
  }
  return $path;
}

/**
 * 递归删除目录
 * 
 * @param mixed $dir
 * @return void
 * @author seatle <seatle@foxmail.com> 
 * @created time :2016-09-18 10:17
 */
function deldir($dir)
{
  //先删除目录下的文件：
  $dh = opendir($dir);
  while ($file = readdir($dh)) {
    if ($file != "." && $file != "..") {
      $fullpath = $dir . "/" . $file;
      if (!is_dir($fullpath)) {
        unlink($fullpath);
      } else {
        deldir($fullpath);
      }
    }
  }

  closedir($dh);
  //删除当前文件夹：
  if (rmdir($dir)) {
    return true;
  } else {
    return false;
  }
}

/**
 * 递归修改目录权限
 *
 * @param mixed $path 目录
 * @param mixed $filemode 权限
 * @return bool
 */
function chmodr($path, $filemode)
{
  if (!is_dir($path)) {
    return @chmod($path, $filemode);
  }

  $dh = opendir($path);
  while (($file = readdir($dh)) !== false) {
    if ($file != '.' && $file != '..') {
      $fullpath = $path . '/' . $file;
      if (is_link($fullpath)) {
        return FALSE;
      } elseif (!is_dir($fullpath) && !@chmod($fullpath, $filemode)) {
        return FALSE;
      } elseif (!chmodr($fullpath, $filemode)) {
        return FALSE;
      }
    }
  }

  closedir($dh);

  if (@chmod($path, $filemode)) {
    return TRUE;
  } else {
    return FALSE;
  }
}

/**
 * 数组格式化为CSV
 * 
 * @param mixed $data
 * @return void
 * @author seatle <seatle@foxmail.com> 
 * @created time :2016-07-29 11:32
 */
function format_csv($data)
{
  foreach ($data as $k => $v) {
    $v = str_replace(",", "", $v);
    $v = str_replace("，", "", $v);
    $data[$k] = $v;
  }
  return implode(",", $data);
}

/**
 * 判断是否为utf8字符串
 * @parem $str
 * @return bool
 */
function is_utf8($str)
{
  if ($str === mb_convert_encoding(mb_convert_encoding($str, "UTF-32", "UTF-8"), "UTF-8", "UTF-32")) {
    return true;
  } else {
    return false;
  }
}

/**
 * 获取文件编码
 * @param $string
 * @return string
 */
function get_encoding($string)
{
  $encoding = mb_detect_encoding($string, array('UTF-8', 'GBK', 'GB2312', 'LATIN1', 'ASCII', 'BIG5'));
  return strtolower($encoding);
}

/**
 * 转换数组值的编码格式
 * @param  array $arr           
 * @param  string $toEncoding   
 * @param  string $fromEncoding 
 * @return array                
 */
function array_iconv($arr, $from_encoding, $to_encoding)
{
  eval('$arr = ' . iconv($from_encoding, $to_encoding . '//IGNORE', var_export($arr, TRUE)) . ';');
  return $arr;
}

/**
 * 从普通时间返回Linux时间截(strtotime中文处理版)
 * @parem string $dtime
 * @return int
 */
function cn_strtotime($dtime)
{
  if (!preg_match("/[^0-9]/", $dtime)) {
    return $dtime;
  }
  $dtime = trim($dtime);
  $dt = array(1970, 1, 1, 0, 0, 0);
  $dtime = preg_replace("/[\r\n\t]|日|秒/", " ", $dtime);
  $dtime = str_replace("年", "-", $dtime);
  $dtime = str_replace("月", "-", $dtime);
  $dtime = str_replace("时", ":", $dtime);
  $dtime = str_replace("分", ":", $dtime);
  $dtime = trim(preg_replace("/[ ]{1,}/", " ", $dtime));
  $ds = explode(" ", $dtime);
  $ymd = explode("-", $ds[0]);
  if (!isset($ymd[1])) {
    $ymd = explode(".", $ds[0]);
  }
  if (isset($ymd[0])) {
    $dt[0] = $ymd[0];
  }
  if (isset($ymd[1])) $dt[1] = $ymd[1];
  if (isset($ymd[2])) $dt[2] = $ymd[2];
  if (strlen($dt[0]) == 2) $dt[0] = '20' . $dt[0];
  if (isset($ds[1])) {
    $hms = explode(":", $ds[1]);
    if (isset($hms[0])) $dt[3] = $hms[0];
    if (isset($hms[1])) $dt[4] = $hms[1];
    if (isset($hms[2])) $dt[5] = $hms[2];
  }
  foreach ($dt as $k => $v) {
    $v = preg_replace("/^0{1,}/", '', trim($v));
    if ($v == '') {
      $dt[$k] = 0;
    }
  }
  $mt = mktime($dt[3], $dt[4], $dt[5], $dt[1], $dt[2], $dt[0]);
  if (!empty($mt)) {
    return $mt;
  } else {
    return strtotime($dtime);
  }
}

function cn_substr($string, $length = 80, $etc = '...', $count_words = true)
{
  mb_internal_encoding("UTF-8");
  if ($length == 0) return '';
  if (strlen($string) <= $length) return $string;
  preg_match_all("/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/", $string, $info);
  if ($count_words) {
    $j = 0;
    $wordscut = "";
    for ($i = 0; $i < count($info[0]); $i++) {
      $wordscut .= $info[0][$i];
      if (ord($info[0][$i]) >= 128) {
        $j = $j + 2;
      } else {
        $j = $j + 1;
      }
      if ($j >= $length) {
        return $wordscut . $etc;
      }
    }
    return join('', $info[0]);
  }
  return join("", array_slice($info[0], 0, $length)) . $etc;
}

/**
 * 获取文件后缀名
 *
 * @param mixed $file_name 文件名
 * @static
 *
 * @access public
 * @return string
 */
function get_extension($file_name)
{
  $ext = explode('.', $file_name);
  $ext = array_pop($ext);
  return strtolower($ext);
}

// 获取 Url 跳转后的真实地址
function getrealurl($url)
{
  if (empty($url)) {
    return $url;
  }
  $header = get_headers($url, 1);
  if (empty($header[0]) || empty($header[1])) {
    return $url;
  }
  if (strpos($header[0], '301') || strpos($header[0], '302')) {
    if (empty($header['Location'])) {
      return $url;
    }
    if (is_array($header['Location'])) {
      return $header['Location'][count($header['Location']) - 1];
    } else {
      return $header['Location'];
    }
  } else {
    return $url;
  }
}

// 解压服务器用 Content-Encoding:gzip 压缩过的数据
// function gzdecode($data)
// {
//   $flags = ord(substr($data, 3, 1));
//   $headerlen = 10;
//   $extralen = 0;
//   $filenamelen = 0;
//   if ($flags & 4) {
//     $extralen = unpack('v', substr($data, 10, 2));
//     $extralen = $extralen[1];
//     $headerlen += 2 + $extralen;
//   }
//   if ($flags & 8)         // Filename
//     $headerlen = strpos($data, chr(0), $headerlen) + 1;
//   if ($flags & 16)         // Comment
//     $headerlen = strpos($data, chr(0), $headerlen) + 1;
//   if ($flags & 2)         // CRC at end of file
//     $headerlen += 2;
//   $unpacked = @gzinflate(substr($data, $headerlen));
//   if ($unpacked === FALSE) $unpacked = $data;
//   return $unpacked;
// }

/**
 * 数字金额转换为中文
 * @param string|integer|float $num 目标数字
 * @param boolean $sim 使用小写（默认）
 * @return string
 */
function number2chinese($num, $sim = FALSE)
{
  if (!is_numeric($num)) return '含有非数字非小数点字符！';
  $char = $sim ? array('零', '一', '二', '三', '四', '五', '六', '七', '八', '九') : array('零', '壹', '贰', '叁', '肆', '伍', '陆', '柒', '捌', '玖');
  $unit = $sim ? array('', '十', '百', '千', '', '万', '亿', '兆') : array('', '拾', '佰', '仟', '', '萬', '億', '兆');
  $retval = '';

  $num = sprintf("%01.2f", $num);

  list($num, $dec) = explode('.', $num);

  // 小数部分
  if ($dec['0'] > 0) {
    $retval .= "{$char[$dec['0']]}角";
  }
  if ($dec['1'] > 0) {
    $retval .= "{$char[$dec['1']]}分";
  }

  // 整数部分
  if ($num > 0) {
    $retval = "元" . $retval;
    $f = 1;
    $str = strrev(intval($num));
    for ($i = 0, $c = strlen($str); $i < $c; $i++) {
      if ($str[$i] > 0) {
        $f = 0;
      }
      if ($f == 1 && $str[$i] == 0) {
        $out[$i] = "";
      } else {
        $out[$i] = $char[$str[$i]];
      }
      $out[$i] .= $str[$i] != '0' ? $unit[$i % 4] : '';
      if ($i > 1 and $str[$i] + $str[$i - 1] == 0) {
        $out[$i] = '';
      }
      if ($i % 4 == 0) {
        $out[$i] .= $unit[4 + floor($i / 4)];
      }
    }
    $retval = join('', array_reverse($out)) . $retval;
  }
  return $retval;
}

function colorize($str, $status = "info")
{
  $out = "";
  switch ($status) {
    case 'succ':
      $out = "\033[32m";    // Blue
      break;
    case "error":
      $out = "\033[31m";    // Red
      break;
    case "warn":
      $out = "\033[33m";    // Yellow
      break;
    case "note":
      $out = "\033[34m";    // Green
      break;
    case "debug":
      $out = "\033[36m";    // Green
      break;
    default:
      $out = "\033[0m";     // info
      break;
  }
  return $out . $str . "\033[0m";
}

function node_to_array($dom, $node)
{
  if (!is_a($dom, 'DOMDocument') || !is_a($node, 'DOMNode')) {
    return false;
  }

  $array = array();
  // Discard empty nodes
  $localName = trim($node->localName);
  if (empty($localName)) {
    return false;
  }
  if (XML_TEXT_NODE == $node->nodeType) {
    return $node->nodeValue;
  }
  foreach ($node->attributes as $attr) {
    $array['@' . $attr->localName] = $attr->nodeValue;
  }
  foreach ($node->childNodes as $childNode) {
    if ((isset($childNode->childNodes->length) && 1 == $childNode->childNodes->length) &&
      XML_TEXT_NODE == $childNode->firstChild->nodeType
    ) {
      $array[$childNode->localName] = $childNode->nodeValue;
    } else {
      if (false !== ($a = node_to_array($dom, $childNode))) {
        $array[$childNode->localName] = $a;
      }
    }
  }
  return $array;
}

function is_win()
{
  // return false;
  return strtoupper(substr(PHP_OS, 0, 3)) === "WIN";
}

/**
 * 和 http_build_query 相反，分解出参数
 * 
 * @return void
 * @author seatle <seatle@foxmail.com> 
 * @created time :2016-05-16 17:29
 */
function http_split_query($query, $is_query = false)
{
  if (!$is_query) {
    $parse_arr = parse_url($query);
    if (empty($parse_arr['query'])) {
      return array();
    }
    $query = $parse_arr['query'];
  }

  $query_arr = explode("&", $query);
  $params = array();
  foreach ($query_arr as $val) {
    $arr = explode("=", $val);
    $params[$arr[0]] = $arr[1];
  }
  return $params;
}
