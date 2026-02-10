<?php

use app\controllers\db;
use app\controllers\log;



function load_config($slug)
{
  log::step("加载配置: " . $slug);
  if (empty($slug)) return false;

  $slug_exp = explode(":", $slug);
  $config_path = dirname(__DIR__)  . str_start(env('CONFIG_PATH'), '/');
  var_dump($config_path);
  log::step($config_path, 2);
  $config_path = str_end($config_path, '/') . $slug_exp[0] . '.php';
  log::step($config_path, 2);
  if (file_exists($config_path)) {
    $configs = require $config_path;
    // var_dump($configs);
    if (isset($configs[$slug_exp[1]])) {
      $curConfig = $configs[$slug_exp[1]];

      // $curConfig['name'] = $curConfig['name'] ?? $slug;

      log::step($slug . " => " . ($curConfig['name'] ?? $slug), 2);
      // log::step($curConfig, 2);
      if (!empty($curConfig['extends'])) {
        $curConfig = merge_config(load_config($curConfig['extends']), $curConfig,);
        // log::step($slug . " => " . $curConfig['name'], 2);
        // log::step($curConfig, 2);
      }
      return $curConfig;
    }
  };
  return false;
}

function merge_config($ext, $cur)
{
  if (empty($ext)) return $cur;
  $extName = $ext['name'] ?? $ext['slug'];
  $curName = $cur['name'] ?? $cur['slug'];
  log::step("合并配置: " . $extName . ' <= ' . $curName);
  // bool, int, string
  foreach (
    [
      "name"                 => [],
      "slug"                 => [],
      'log_show'             => ['LOG_SHOW'],
      'log_type'             => ['LOG_TYPE'],

      'input_encoding'       => ['INPUT_ENCODING'],
      'output_encoding'      => ['OUTPUT_ENCODING'],

      "tasknum"              => [],
      "multiserver"          => [],
      "serverid"             => [],
      "save_running_state"   => [],


      'interval'             => [],
      'timeout'              => [],
      'max_try'              => [],
      'max_depth'            => [],
      'max_fields'           => [],

      'export.type'          => ['export_type'],
      'export.file'          => ['export_file'],
      'export.table'         => ['export_table'],

      "queue_config.host"    => ['queue_host', "QUEUE_HOST"],
      "queue_config.port"    => ['queue_port', "QUEUE_PORT"],
      "queue_config.pass"    => ['queue_pass', "QUEUE_PASS"],
      "queue_config.db"      => ['queue_db', "QUEUE_DB"],
      "queue_config.prefix"  => ['queue_prefix', "QUEUE_PREFIX"],
      "queue_config.timeout" => ['queue_timeout', "QUEUE_TIMEOUT"],

      "db_config.host"       => ['db_host', "DB_HOST"],
      "db_config.port"       => ['db_port', "DB_PORT"],
      "db_config.user"       => ['db_user', "DB_USER"],
      "db_config.pass"       => ['db_pass', "DB_PASS"],
      "db_config.name"       => ['db_name', "DB_NAME"],

      'beforeGetConfig'      => [],
      'afterGetConfig'       => [],
      'beforeSyncTable'      => [],
      'afterSyncTable'       => [],
      'beforeCreateSpider'   => [],
      'afterCreateSpider'    => [],
      'beforeStartSpider'    => [],
    ] as $alias => $keys
  ) {
    array_unshift($keys, $alias);
    foreach ($keys as $key) {
      if ($curVal = array_get($cur, $key)) {
        // var_dump($curName . ": " . $key);
        $ext = array_set($ext, $alias, $curVal);
      }
    }
    // if (!isset($cur[$alias])) {
    //   array_unshift($keys, $alias);
    //   foreach ($keys as $key) {
    //     if ($extVal = array_get($ext, $key)) {
    //       log::step("填补配置参数: " . $alias . " = " . $extVal, 2);
    //       $cur = array_set($cur, $alias, $extVal);
    //     }
    //   }
    // }
    unset($alias, $keys);
  }

  foreach (
    [] as $alias => $keys
  ) {
    array_unshift($keys, $alias);
    foreach ($keys as $key) {
      if (!is_null($val = array_get($cur, $key))) {
        var_dump($extName . ": " . $key . ' = ' . $val);
      }
      // if ($extVal = array_get($ext, $key)) {
      //   log::step("填补配置参数: " . $alias . " = " . $extVal, 2);
      //   $cur = array_set($cur, $alias, $extVal);
      // }
    }
    // if (!isset($cur[$alias])) {
    //   var_dump($alias);
    // }
    unset($alias, $keys);
  }

  // array
  foreach (
    [
      "proxy",
      'user_agent',
      'client_ip',

      "domains",
      "scan_urls",
      "list_url_regexes",
      "list_url_regexes_remove",
      "list_urls",
      "content_url_regexes",
      "content_url_regexes_remove",
      "content_urls",
    ] as $key
  ) {
    if (isset($ext[$key])) {
      log::step("拼接配置参数: " . $key, 2);
      $ext[$key] = array_merge($ext[$key], $cur[$key] ?? []);
      log::step($ext[$key], 4);
    }
    unset($alias, $keys);
  }

  // object
  foreach (
    [
      "queue_config",
      'export',
      "db_config",
    ] as $key
  ) {
    if (isset($ext[$key])) {
      log::step("合并配置参数: " . $key, 2);
      $ext[$key] = array_merge($ext[$key], $cur[$key] ?? []);
      // $cur[$key] = array_merge($ext[$key], $cur[$key] ?? []);
      log::step($ext[$key], 4);
      // log::step($cur[$key], 4);
    }
  }
  if (isset($ext['fields'])) {
    log::step("合并抽取规则: ", 2);
    $extFields      = $ext['fields'] ?? [];
    $curFields      = $cur['fields'] ?? [];
    foreach ($curFields as $curFieldKey => $curField) {
      if (in_array($curFieldKey, array_keys($extFields))) {
        $curField['name'] = $curFieldKey;
        $extFields[$curFieldKey] = $curField;
      }
    }
    unset($extFieldKey, $extField);
    $ext['fields'] = $extFields;
    unset($extFields,   $curFields);
    log::step($ext['fields'], 4);
    unset($key);
  }

  return $ext;
}
var_dump($argv);
if (!$currentConfig = load_config($argv[2])) die("错误：配置文件不存在！");
// cmd > env > cur > ext
// var_dump($configs);

// $configs = require_once __DIR__ . '/../.configs/' . $slug_exp[0] . '.php';

// $defaultConfig = $configs['default'];

// $currentConfig = $configs[$slug_exp[1] ?? 'default'];
/**
 * 
 * 优先级: Command > Env > Current > Default
 */
// $currentConfig = merge_config($currentConfig, $_ENV);
$currentConfig = merge_config($currentConfig, $commandConfig);

log::step($currentConfig, 2);
log::step($currentConfig['fields'] ?? NULL, 2);

log::step('检测配置: ' . str_pad('log', 16));
log::step(['log_show' => $currentConfig['log_show'] ?? NULL, 'log_file' => $currentConfig['log_file'] ?? NULL, 'log_type' => $currentConfig['log_type'] ?? NULL,], 2);

log::step('检测配置: ' . str_pad('encoding', 16));
log::step(['input_encoding' => $currentConfig['input_encoding'] ?? NULL, 'output_encoding' => $currentConfig['output_encoding'] ?? NULL,], 2);

log::step('检测配置: ' . str_pad('tasknum', 16) . ' = ' . ($currentConfig['tasknum'] ?? NULL));

log::step('检测配置: ' . str_pad('multiserver', 16) . ' = ' . ($currentConfig['multiserver'] ?? NULL));

log::step('检测配置: ' . str_pad('serverid', 16) . ' = ' . ($currentConfig['serverid'] ?? NULL));

log::step('检测配置: queue_config');
log::step($currentConfig['queue_config'] ?? NULL, 2);

log::step('检测配置: export');
log::step($currentConfig['export'] ?? NULL, 2);

log::step('检测配置: db_config');
log::step($currentConfig['db_config'] ?? NULL, 2);

// exit;
// $defaultConfig['db_config']      = $defaultConfig['db_config']      ?? ['host'  => $_ENV['DB_HOST'] ?? '127.0.0.1', 'port'  => $_ENV['DB_PORT'] ?? 3306, 'user'  => $_ENV['DB_USER'] ?? 'root', 'pass'  => $_ENV['DB_PASS'] ?? 'root', 'name'  => $_ENV['DB_NAME'] ?? 'phpspider',];
// $defaultConfig['queue_config']   = $defaultConfig['queue_config']   ?? ['host' => $_ENV['REDIS_HOST'] ?? '127.0.0.1',  'port' => $_ENV['REDIS_PORT'] ?? 6379,  'pass' => $_ENV['REDIS_PASS'] ?? '',  'db' => $_ENV['REDIS_DB'] ?? 5,  'prefix' => $_ENV['REDIS_PREFIX'] ?? 'phpspider',  'timeout'   => $_ENV['REDIS_TIMEOUT'] ?? 30,];


return $currentConfig;

// var_dump($defaultConfig);
// foreach ($defaultConfig['fields'] as $key => $field) {
//     var_dump($key);
// }
// exit;

// $currentConfig['started_at'] = time();


// $currentConfig['slug']         = $commandConfig['slug'] ?? $currentConfig['slug']         ?? $defaultConfig['slug'] . ($slug_exp[1] ?? '');
// $currentConfig['log_debug']    = $commandConfig['log_debug'] ?? $currentConfig['log_debug']    ?? $defaultConfig['log_debug']              ?? false;


// $currentConfig['log_show']    = $commandConfig['log_show'] ?? $currentConfig['log_show']    ?? $defaultConfig['log_show'];
// $currentConfig['log_type']    = $commandConfig['log_type'] ?? $currentConfig['log_type']    ?? $defaultConfig['log_type'];
// $currentConfig['max_depth']    = $commandConfig['max_depth'] ?? $currentConfig['max_depth']    ?? $defaultConfig['max_depth'];
// $currentConfig['max_fields']   = $commandConfig['max_fields'] ?? $currentConfig['max_fields']   ?? $defaultConfig['max_fields'];
// $currentConfig['export_type']  = $commandConfig['export_type'] ?? $currentConfig['export_type']  ?? $defaultConfig['export_type'];
// $currentConfig['export_table'] = $commandConfig['export_table'] ?? $currentConfig['export_table'] ?? $defaultConfig['export_table'];
// $currentConfig['db_config']              = $currentConfig['db_config']       ?? $defaultConfig['db_config'];
// $currentConfig['queue_config']           = $currentConfig['queue_config']    ?? $defaultConfig['queue_config'];

// $currentConfig['domains']                = $currentConfig['domains']    ?? $defaultConfig['domains'];
// $currentConfig['scan_urls']              = $currentConfig['scan_urls']    ?? $defaultConfig['scan_urls'];
// $currentConfig['list_url_regexes']       = $currentConfig['list_url_regexes']    ?? $defaultConfig['list_url_regexes'];
// $currentConfig['content_url_regexes']    = $currentConfig['content_url_regexes']    ?? $defaultConfig['content_url_regexes'];


// $defaultDbConfig    = $defaultConfig['db_config'];
// $defaultQueueConfig = $defaultConfig['queue_config'];



// switch ($currentConfig['export_type']) {
//   case "db":
//     $currentConfig['export'] = ['type' => 'db',  'table' => $currentConfig['export_table'],];
//     break;
//   case "csv":
//     $currentConfig['export'] = ['type' => 'csv', 'table' => $currentConfig['export_table'], 'file'  => './data/' . $currentConfig['slug'] . '.csv',];
//     break;
//   case "sql":
//     $currentConfig['export'] = ['type' => 'csv', 'table' => $currentConfig['export_table'], 'file'  => './data/' . $currentConfig['slug'] . '.sql',];
//     break;
//   default:
//     break;
// }

// $defaultFields      = $defaultConfig['fields'];
// $currentFields      = $currentConfig['fields'];
// foreach ($currentFields as $currentFieldKey => $currentField) {
//   if (in_array($currentFieldKey, array_keys($defaultFields))) {
//     $currentField['name'] = $currentFieldKey;
//     $defaultFields[$currentFieldKey] = $currentField;
//   }
// }
// unset($defaultFieldKey, $defaultField);
// $currentConfig['fields'] = $defaultFields;
// unset($defaultFields,   $currentFields);
// var_dump($currentConfig['fields']);
// exit;
// var_dump($currentConfig['tasknum']);
// exit;
if (!is_dir(__DIR__ . '/../cache'))  mkdir(__DIR__ . '/../cache');
if (!is_dir(__DIR__ . '/../data'))   mkdir(__DIR__ . '/../data');
if (!is_dir(__DIR__ . '/../logs'))   mkdir(__DIR__ . '/../logs');


// var_dump($spider);

// for ($i = 1; $i <= 5; $i++) {
//     echo "\e[H\e[J";
//     $e = printf("My name is \033[45m %s \033[0m, I'm %d years old.", "John", $i) . PHP_EOL;
//     echo $e;
// }

// echo "\033[30m  this is a test msg  \033[0m" . PHP_EOL;

// echo "\033[45m  this is a test msg  \033[0m" . PHP_EOL;
// $phpspider = new phpspider($currentConfig);


// function logInfo($phpspider, $currentConfig = null)
// {
//     if (!$currentConfig) $currentConfig = $phpspider::$currentConfigs;
//     echo "\e[H\e[J";
//     $msg =
//         "--------------------------------------\033[7m  PHPSPIDER  \033[0m------------------------------------------------------" . PHP_EOL .
//         "PhpSpider version: " . phpspider::VERSION . "                                    PHP version: " . phpversion() . "" . PHP_EOL .
//         "start time: " . date("Y-m-d H:i:s", $currentConfig['created_at']) . "                         run 0 days 0 hours 0 minutes" . PHP_EOL .
//         "spider name: " . $currentConfig['name'] . PHP_EOL .
//         "load average:1.99，2，2" . PHP_EOL .
//         "document: https://doc.phpspider.org" . PHP_EOL .
//         "--------------------------------------\033[7m    TASKS    \033[0m------------------------------------------------------" . PHP_EOL .
//         "\033[7mtaskid\033[0m       	\033[7mpid\033[0m	\033[7mmem\033[0m	\033[7mcollect succ\033[0m	\033[7mcollect fail\033[0m	\033[7mspeed\033[0m" . PHP_EOL .
//         "1	 38718	" . round(memory_get_usage() / 1024 / 1024, 2) . "MB	" . $phpspider::$collect_succ . "      " . $phpspider::$collect_fail . "	0.89/s" . PHP_EOL .
//         "------------------------------------\033[7m  COLLECT STATUS  \033[0m----------------------------------------------------" . PHP_EOL .
//         "\033[7mfind pages\033[0m	\033[7mcollected\033[0m	\033[7mqueue\033[0m	\033[7mfields\033[0m	\033[7mdepth\033[0m	" . PHP_EOL .
//         "2671	1198	1473	6	" . PHP_EOL .
//         "Press Ctrl-C to quit. Start success" . PHP_EOL;

//     echo $msg;
// }
// 格式化当前时间
// echo date("Y-m-d H:i:s"); // 输出示例: 2023-10-05 14:30:45
