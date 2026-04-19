<?php

return [
  "merge-config" => [
    "name"                           => "🟡【单元】合并配置",
    'extends' => 'default:unit',
    'queue_prefix' => 'phpspider:unit:merge-config',
    'afterGetConfig' => function ($currentConfig, $commandConfig) {
      print_r($commandConfig);
      print_r($currentConfig);
      print_r($currentConfig['queue_config']);
      // print_r([$currentConfig, $commandConfig]);
      // print_r([$currentConfig, $commandConfig]);
      exit;
    }
  ],
  "xpath-selector" => [],
  "css-selector" => [],
  "extract-field" => [],
  "extract-page" => [],
];
