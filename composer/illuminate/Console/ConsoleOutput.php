<?php

namespace Illuminate\Console;

class ConsoleOutput
{
  // ANSI转义码开始
  const ANSI_START = "\033[";
  // ANSI转义码结束
  const ANSI_END = "m";
  const ANSI_COLORS = [
    'reset' => '0',
    'black' => '0;30',
    'red' => '0;31',
    'green' => '0;32',
    'yellow' => '1;33',
    'blue' => '0;34',
    'purple' => '0;35',
    'cyan' => '0;36',
    'white' => '1;37',
  ];
  const ANSI_RESET = "\033[0m";
  public $messages = [
    ["Langnang Composer Framework "],
    ["8.83.27\n", 'green'],
    ["
Usage:
  command [options] [arguments]

Options:
  -h, --help            Display help for the given command. When no command is given display help for the list command    
  -q, --quiet           Do not output any message
  -V, --version         Display this application version
      --ansi|--no-ansi  Force (or disable --no-ansi) ANSI output
  -n, --no-interaction  Do not ask any interactive question
      --env[=ENV]       The environment the command should run under
  -v|vv|vvv, --verbose  Increase the verbosity of messages: 1 for normal output, 2 for more verbose output and 3 for debug
"]
  ];
  public function print()
  {
    foreach ($this->messages as $color_message) {
      $message = $color_message[0];
      $color = $color_message[1] ?? 'reset';

      $color_code = self::ANSI_COLORS[$color] ?: self::ANSI_COLORS['reset'];
      echo self::ANSI_START . "$color_code" . self::ANSI_END . "$message" . self::ANSI_RESET;
    }
    $commands = [
      "Available Commands" => []
    ];
    foreach (app('console')->commands as $name => $command) {
      // var_dump($name);
    }
  }
}
