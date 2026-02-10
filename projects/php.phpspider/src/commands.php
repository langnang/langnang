<?php

use app\controllers\log;
use app\controllers\phpspider;

define("ARG_REQUIRED", 1);
define("ARG_OPTIONAL", 0);
define("ARG_NONESSEN", -1);

$commands = [
  // required:
  // "required"               => ["name" => "required",            "slug" => "",  "type" => ARG_REQUIRED, "priority" => 000, "pause" => false, "description" => "",],
  "command"                => ["name" => "command",             "slug" => "c", "type" => ARG_REQUIRED, "priority" => 000, "pause" => false, "description" => "",],
  "slug"                   => ["name" => "slug",                "slug" => "s", "type" => ARG_REQUIRED, "priority" => 000, "pause" => false, "description" => "",],

  "log_show"               => ["name" => "log_show",            "slug" => "",  "type" => ARG_REQUIRED, "priority" => 699, "pause" => false, "description" => "",],
  "log_type"               => ["name" => "log_type",            "slug" => "",  "type" => ARG_REQUIRED, "priority" => 698, "pause" => false, "description" => "",],

  "input_encoding"         => ["name" => "input_encoding",      "slug" => "",  "type" => ARG_REQUIRED, "priority" => 689, "pause" => false, "description" => "",],
  "output_encoding"        => ["name" => "output_encoding",     "slug" => "",  "type" => ARG_REQUIRED, "priority" => 688, "pause" => false, "description" => "",],

  "tasknum"                => ["name" => "tasknum",             "slug" => "",  "type" => ARG_REQUIRED, "priority" => 679, "pause" => false, "description" => "",],
  "multiserver"            => ["name" => "multiserver",         "slug" => "",  "type" => ARG_REQUIRED, "priority" => 678, "pause" => false, "description" => "",],
  "serverid"               => ["name" => "serverid",            "slug" => "",  "type" => ARG_REQUIRED, "priority" => 677, "pause" => false, "description" => "",],
  "save_running_state"     => ["name" => "save_running_state",  "slug" => "",  "type" => ARG_REQUIRED, "priority" => 676, "pause" => false, "description" => "",],

  "queue_config"           => ["name" => "queue_config",        "slug" => "",  "type" => ARG_REQUIRED, "priority" => 675, "pause" => false, "description" => "",],
  "queue_host"             => ["name" => "queue_host",          "slug" => "",  "type" => ARG_REQUIRED, "priority" => 675, "pause" => false, "description" => "",],
  "queue_port"             => ["name" => "queue_port",          "slug" => "",  "type" => ARG_REQUIRED, "priority" => 675, "pause" => false, "description" => "",],
  "queue_pass"             => ["name" => "queue_pass",          "slug" => "",  "type" => ARG_REQUIRED, "priority" => 675, "pause" => false, "description" => "",],
  "queue_db"               => ["name" => "queue_db",            "slug" => "",  "type" => ARG_REQUIRED, "priority" => 675, "pause" => false, "description" => "",],
  "queue_prefix"           => ["name" => "queue_prefix",        "slug" => "",  "type" => ARG_REQUIRED, "priority" => 675, "pause" => false, "description" => "",],
  "queue_timeout"          => ["name" => "queue_timeout",       "slug" => "",  "type" => ARG_REQUIRED, "priority" => 675, "pause" => false, "description" => "",],

  "interval"               => ["name" => "interval",            "slug" => "",  "type" => ARG_REQUIRED, "priority" => 669, "pause" => false, "description" => "",],
  "timeout"                => ["name" => "timeout",             "slug" => "",  "type" => ARG_REQUIRED, "priority" => 668, "pause" => false, "description" => "",],
  "max_try"                => ["name" => "max_try",             "slug" => "",  "type" => ARG_REQUIRED, "priority" => 659, "pause" => false, "description" => "",],
  "max_depth"              => ["name" => "max_depth",           "slug" => "",  "type" => ARG_REQUIRED, "priority" => 658, "pause" => false, "description" => "",],
  "max_fields"             => ["name" => "max_fields",          "slug" => "",  "type" => ARG_REQUIRED, "priority" => 657, "pause" => false, "description" => "",],

  "proxy"                  => ["name" => "proxy",               "slug" => "",  "type" => ARG_REQUIRED, "priority" => 649, "pause" => false, "description" => "",],
  "user_agent"             => ["name" => "user_agent",          "slug" => "",  "type" => ARG_REQUIRED, "priority" => 648, "pause" => false, "description" => "",],
  "client_ip"              => ["name" => "client_ip",           "slug" => "",  "type" => ARG_REQUIRED, "priority" => 647, "pause" => false, "description" => "",],

  "export"                 => ["name" => "export",              "slug" => "",  "type" => ARG_REQUIRED, "priority" => 639, "pause" => false, "description" => "",],
  "export_type"            => ["name" => "export_type",         "slug" => "",  "type" => ARG_REQUIRED, "priority" => 639, "pause" => false, "description" => "",],
  "export_file"            => ["name" => "export_file",         "slug" => "",  "type" => ARG_REQUIRED, "priority" => 639, "pause" => false, "description" => "",],
  "export_table"           => ["name" => "export_table",        "slug" => "",  "type" => ARG_REQUIRED, "priority" => 639, "pause" => false, "description" => "",],

  "db_config"              => ["name" => "db_config",           "slug" => "",  "type" => ARG_REQUIRED, "priority" => 638, "pause" => false, "description" => "",],
  "db_host"                => ["name" => "db_host",             "slug" => "",  "type" => ARG_REQUIRED, "priority" => 638, "pause" => false, "description" => "",],
  "db_port"                => ["name" => "db_port",             "slug" => "",  "type" => ARG_REQUIRED, "priority" => 638, "pause" => false, "description" => "",],
  "db_user"                => ["name" => "db_user",             "slug" => "",  "type" => ARG_REQUIRED, "priority" => 638, "pause" => false, "description" => "",],
  "db_pass"                => ["name" => "db_pass",             "slug" => "",  "type" => ARG_REQUIRED, "priority" => 638, "pause" => false, "description" => "",],
  "db_name"                => ["name" => "db_name",             "slug" => "",  "type" => ARG_REQUIRED, "priority" => 638, "pause" => false, "description" => "",],

  "domains"                => ["name" => "domains",             "slug" => "",  "type" => ARG_REQUIRED, "priority" => 609, "pause" => false, "description" => "",],
  "scan_urls"              => ["name" => "scan_urls",           "slug" => "",  "type" => ARG_REQUIRED, "priority" => 608, "pause" => false, "description" => "",],
  "list_url_regexes"       => ["name" => "list_url_regexes",    "slug" => "",  "type" => ARG_REQUIRED, "priority" => 607, "pause" => false, "description" => "",],
  "list_urls"              => ["name" => "list_urls",           "slug" => "",  "type" => ARG_REQUIRED, "priority" => 606, "pause" => false, "description" => "",],
  "content_url_regexes"    => ["name" => "content_url_regexes", "slug" => "",  "type" => ARG_REQUIRED, "priority" => 605, "pause" => false, "description" => "",],
  "content_urls"           => ["name" => "content_urls",        "slug" => "",  "type" => ARG_REQUIRED, "priority" => 604, "pause" => false, "description" => "",],
  // optional::
  // "optional"               => ["name" => "optional",            "slug" => "",  "type" => ARG_OPTIONAL, "priority" => 000, "pause" => false, "description" => "",],
  // nonessential
  // "nonessential"           => ["name" => "nonessential",        "slug" => "",  "type" => ARG_NONESSEN, "priority" => 000, "pause" => false, "description" => "",],
  "start"                  => ["name" => "start",               "slug" => "",  "type" => ARG_NONESSEN, "priority" => 840, "pause" => false, "description" => "",],
  "test"                   => ["name" => "test",                "slug" => "t", "type" => ARG_NONESSEN, "priority" => 850, "pause" => false, "description" => "", "handler" => function ($value,  $commands, &$config) {
    $config['log_show'] = true;
    $config['log_type'] = "step,info,debug,success,warn,error";
    // 'multiserver' => true
    $config['multiserver'] = false;
    $config['tasknum'] = false;
    $config['save_running_state'] = false;

    $config['max_fields'] = 1;
  }],
  "debug"                  => ["name" => "debug",               "slug" => "d", "type" => ARG_NONESSEN, "priority" => 8600, "pause" => false, "description" => "", "handler" => function ($value,  $commands, &$config) {
    $config['log_show'] = true;
    $config['log_type'] = "info,debug,success,warn,error";
  }],
  "stop"                   => ["name" => "stop",                "slug" => "",  "type" => ARG_NONESSEN, "priority" => 870, "pause" => true,  "description" => "",],
  "kill"                   => ["name" => "kill",                "slug" => "k", "type" => ARG_NONESSEN, "priority" => 880, "pause" => true,  "description" => "",],
  "status"                 => ["name" => "status",              "slug" => "",  "type" => ARG_NONESSEN, "priority" => 890, "pause" => true,  "description" => "",],
  "list"                   => ["name" => "list",                "slug" => "l", "type" => ARG_NONESSEN, "priority" => 960, "pause" => true,  "description" => "", "handler" => function ($value,  $commands, &$config) {
    echo get_ascii_art()
      . "\033[32mPhpSpider\033[0m Version \033[33m" . phpspider::VERSION . "\033[0m " . date('Y-m-d H:i:s') . PHP_EOL
      . PHP_EOL;
    echo ""
      . "\033[33mUsage:\033[0m " . PHP_EOL
      . "  command slug [options] [arguments]" . PHP_EOL
      . PHP_EOL
      . "\033[33mOptions:\033[0m " . PHP_EOL;
    foreach (
      array_filter($commands, function ($item) {
        return $item['priority'] >= 900 && $item['priority'] < 1000;
      }) as $key => $command
    ) {
      echo "  \033[32m" . str_pad((empty($command['slug']) ? "   " : "-" . $command['slug'] . ",") . " --" . $key, 30) . "\033[0m " . $command['name'] . PHP_EOL;
    }
    echo "\033[33mAvailable commands:\033[0m " . PHP_EOL;
    foreach (
      array_filter($commands, function ($item) {
        return $item['priority'] >= 800 && $item['priority'] < 900;
      }) as $key => $command
    ) {
      echo "  \033[32m" . str_pad("" . $key, 30) . "\033[0m " . ($command['name'] ?? '') . PHP_EOL;
    }
    echo "\033[33mAvailable configs:\033[0m " . PHP_EOL;

    foreach (glob(__DIR__ . '/../../.configs/*.php') as $file) {
      $configs = require_once $file;
      if (is_array($configs)) {
        $group = basename($file, ".php");
        echo " \033[33m" .  $group . "\033[0m" . PHP_EOL;
        foreach ($configs as $key => $config) {
          echo "  \033[32m" . str_pad($group . ":" . $key, 30) . "\033[0m " . ($config['name'] ?? '') . PHP_EOL;
        }
      }
    }
    echo  "\033[33mAvailable config options:\033[0m " . PHP_EOL;

    foreach (
      array_filter($commands, function ($item) {
        return $item['priority'] >= 600 && $item['priority'] < 800;
      }) as $key => $command
    ) {
      echo "  \033[32m" . str_pad("--" . $key, 30) . "\033[0m --" . $command['name'] . PHP_EOL;
    }
  }],
  "help"                   => ["name" => "help",                "slug" => "h", "type" => ARG_NONESSEN, "priority" => 970, "pause" => true,  "description" => "", "handler" => function ($value,  $commands, &$config) {
    echo get_ascii_art()
      . "\033[32mPhpSpider\033[0m Version \033[33m" . phpspider::VERSION . "\033[0m " . date('Y-m-d H:i:s') . PHP_EOL
      . PHP_EOL;

    $maxKeyLen = 0;
    $maxSyntaxLen = 0;
    foreach ($commands as $key => &$command) {
      $syntax =  $command['syntax'] = (empty($command['slug']) ? "   " : "-" . $command['slug'] . ",") . "--" . $key;
      // echo "\033[33;1m{$key}        --{$key}  \033[0m" . PHP_EOL;
      if (strlen($key) > $maxKeyLen) {
        $maxKeyLen = strlen($key);
      }
      if (strlen($syntax) > $maxKeyLen) {
        $maxSyntaxLen = strlen($syntax);
      }
    }
    foreach ($commands as $key => $command) {
      echo "\033[33;1m" . str_pad($key, $maxKeyLen + 6, " ") . str_pad($command['syntax'], $maxSyntaxLen + 6, " ") . "  \033[0m" . PHP_EOL;
    }
  }],
  "info"                   => ["name" => "info",                "slug" => "i", "type" => ARG_NONESSEN, "priority" => 980, "pause" => true,  "description" => "", "handler" => function ($value,  $commands, &$config) {
    $cmds = array_filter($commands, function ($item) {
      return $item['type'] === ARG_NONESSEN;
    });
    echo "\033[33;1mphp spider " . implode('|', array_keys($cmds)) . " config:name [-,--]\033[0m" . PHP_EOL;
    echo "\033[33;1mphp spider [-,--] " . implode('|', array_keys($cmds)) . " config:slug \033[0m" . PHP_EOL;
  }],
  "version"                => ["name" => "version",             "slug" => "v", "type" => ARG_NONESSEN, "priority" => 990, "pause" => true,  "description" => "",],
];

function parse_command($start = 0, $len = 1)
{
  log::step("加载命令:");
  global $argv;
  global $commands;

  $shortopts =
    array_reduce(array_filter($commands, function ($item) {
      return !empty($item['slug']) && $item['type'] === ARG_REQUIRED;
    }), function ($total, $item) {
      return $total . $item["slug"] . ":";
    }, "") .
    array_reduce(array_filter($commands, function ($item) {
      return !empty($item['slug']) && $item['type'] === ARG_OPTIONAL;
    }), function ($total, $item) {
      return $total . $item["slug"] . "::";
    }, "") .
    array_reduce(array_filter($commands, function ($item) {
      return !empty($item['slug']) && $item['type'] === ARG_NONESSEN;
    }), function ($total, $item) {
      return $total . $item["slug"] . "";
    }, "");
  // var_dump($shortopts);

  $longopts =
    array_values(array_merge(array_map(function ($item) {
      return $item['name'] . ":";
    }, array_filter($commands, function ($item) {
      return !empty($item['name']) && $item['type'] === ARG_REQUIRED;
    })), array_map(function ($item) {
      return $item['name'] . "::";
    }, array_filter($commands, function ($item) {
      return !empty($item['name']) && $item['type'] === ARG_OPTIONAL;
    })), array_map(function ($item) {
      return $item['name'] . "";
    }, array_filter($commands, function ($item) {
      return !empty($item['name']) && $item['type'] === ARG_NONESSEN;
    }))));
  // var_dump($longopts);

  $rest_index = null;
  $options = getopt($shortopts, $longopts, $rest_index);
  // var_dump($options);
  // $pos_args = array_slice($argv, $rest_index);
  // var_dump($pos_args);
  if (sizeof($options) == 0) {
    // command 命令在前， option 命令在后
    // php spider start default:default --required value --optional --nonessential --option max_fields=1 --option max_depth=1 --option --status
    // echo "\033[33;1mphp spider " . implode('|', $commands) . " config:name [-,--]\033[0m" . PHP_EOL;
    $options = array_slice($argv, $start + $len);
    $argv = array_slice($argv, 00, $start + $len);
    $opt = [];
    $ignore = false;
    foreach ($options as $index => $option) {
      if ($ignore) {
        $ignore = false;
        continue;
      }
      if (str_starts_with($option, '--')) {
        $key = substr($option, 2);
      } else if (str_starts_with($option, '-')) {
        $key = substr($option, 1);
      }
      // var_dump($key);
      if (!empty($key) && isset($commands[$key])) {
        if ($commands[$key]['type'] === ARG_NONESSEN) {
          $val = false;
        } else if ($commands[$key]['type'] === ARG_REQUIRED) {
          $val = $options[$index + 1];
          $ignore = true;
        } else if ($commands[$key]['type'] === ARG_OPTIONAL) {
          $val = $options[$index + 1];
          $ignore = true;
          // 
          if (str_starts_with($val, '-')) {
            $val = false;
            $ignore = false;
          }
        }

        if (!isset($opt[$key])) {
          $opt[$key] = $val;
        } else {
          if (!is_array($opt[$key])) {
            $opt[$key] = [$opt[$key]];
          }
          array_push($opt[$key], $val);
        }
        unset($val);
      }

      unset($key);
    }
    $options = $opt;
  } else {
    // option 命令在前， command 命令在后
    // php spider --required value --optional --nonessential --option max_fields=1 --option max_depth=1 --option start default:default
    // echo "\033[33;1mphp spider [-,--] " . implode('|', $commands) . " config:slug \033[0m" . PHP_EOL;
    // 
    $argv = array_merge(array_slice($argv, 00, $start), array_slice($argv, $rest_index));
    // var_dump($argv);
    // exit;
  }

  if (empty($argv[1])) $argv[1] = 'list';
  $options[$argv[1]]  = false;
  $options["command"] = $argv[1];
  if (!empty($argv[2])) {
    $options['slug']  = $argv[2];
  }

  log::step($options, 2);

  // 排序
  uasort($commands, function ($a, $b) {
    return ($a['priority'] ?? 0) <= ($b['priority'] ?? 0);
  });

  var_dump($argv);
  if (!in_array($argv[1], array_keys(array_filter($commands, function ($item) {
    return $item['priority'] >= 800 && $item['priority'] < 1000;
  })))) {
    die("错误：参数不存在！");
  }
  // var_dump($options);
  // var_dump(array_keys($commands));
  foreach ($commands as $key => $command) {
    if (isset($command['handler'])) {
      if (array_key_exists($key, $options)) {
        log::step("启动命令: " . $key);
        $command['handler']($options[$key], $commands, $options);
        log::step($options, 2);
        if ($command['pause'] ?? false) exit;
      } else if (isset($options[$command['slug']])) {
        log::step("启动命令: " . $key);
        $command['handler']($options[$command['slug']], $commands, $options);
        log::step($options, 2);
        if ($command['pause'] ?? false) exit;
      }
    }
  }

  return $options;
}
$commandConfig = parse_command(1, 2);

// $slug = $argv[2] ?? null;
// $slug_exp = explode(":", $slug);
// if (!file_exists(__DIR__ . '/../../.configs/' . $slug_exp[0] . '.php')) die("配置文件不存在，程序启动失败");

// var_dump($argv, $commandConfig);

// php spider -c start -s question:haodaxue
// php spider --option max_fields:1 --option max_depth:1 start question:haodaxue
// parse_str(implode("&", $argv), $_CLI_ARGV);
// var_dump($_CLI_ARGV);
// unset($_CLI_ARGV['start']);
// // 检测配置变量
// if (!isset($_CLI_ARGV['id'])) {
//     echo "变量不足，程序启动失败";
//     return "变量不足，程序启动失败";
// }

// $options = getopt('a:b:', ['c:', 'd::']);
// var_dump($options);
// exit;
// --serverid 2
return $commandConfig;
