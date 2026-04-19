<?php

use \app\controllers\phpspider;

$default__ = [];
$default__metas = [];
$default__contents = [];

return [
  "_" => [
    'slug'                           => 'default:_',
    'name'                           => '🔴🟡🟢【默认】',
  ],
  "_metas" => [
    'slug'                           => 'default:_metas',
    'name'                           => '🔴🟡🟢【标识】',

  ],
  "_contents"                          => [
    'slug'                           => 'default:_contents',
    'name'                           => '🔴🟡🟢【内容】',
    'log_show'                       => true,
    'log_file'                       => 'logs/default_.log',
    'log_type'                       => 'error',
    'input_encoding'                 => 'UTF-8',
    'output_encoding'                => 'UTF-8',
    'tasknum'                        => 5,
    'multiserver'                    => false,
    'serverid'                       => 1,
    'save_running_state'             => false,
    'queue_config'                   => [
      'host'                         => env('QUEUE_HOST', '127.0.0.1'),
      'port'                         => env('QUEUE_PORT', 6379),
      'pass'                         => env('QUEUE_PASS', ''),
      'db'                           => env('QUEUE_DB', 5),
      'prefix'                       => env('QUEUE_PREFIX', 'phpspider'),
      'timeout'                      => env('QUEUE_TIMEOUT', 30),
    ],
    'proxy'                          => [],
    'interval'                       => 1000,
    'timeout'                        => 5,
    'max_try'                        => 0,
    'max_depth'                      => 0,
    'max_fields'                     => 0,
    'user_agent'                     => [
      phpspider::AGENT_ANDROID,
      phpspider::AGENT_IOS,
      phpspider::AGENT_PC,
      "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36",
      "Mozilla/5.0 (iPhone; CPU iPhone OS 9_3_3 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13G34 Safari/601.1",
      "Mozilla/5.0 (Linux; U; Android 6.0.1;zh_cn; Le X820 Build/FEXCNFN5801507014S) AppleWebKit/537.36 (KHTML, like Gecko)Version/4.0 Chrome/49.0.0.0 Mobile Safari/537.36 EUI Browser/5.8.015S",

    ],
    'client_ip'                      => [
      '192.168.0.2',
      '192.168.0.3',
      '192.168.0.4',
    ],
    'export'                         => [
      'type'                         => 'db', // csv,sql,db
      'file'                         => './data/default_contents.sql',
      'table'                        => 'default_contents',
    ],
    'export_type'                    => 'db',
    'export_table'                   => 'default_contents',
    'db_config'                      => [
      'host'                         => env('DB_HOST', '127.0.0.1'),
      'port'                         => env('DB_PORT', 3306),
      'user'                         => env('DB_USER', 'root'),
      'pass'                         => env('DB_PASS', 'root'),
      'name'                         => env('DB_NAME', 'demo'),
    ],
    'domains'                        => [],
    'scan_urls'                      => [],
    'list_url_regexes'               => [],
    'list_url_regexes_remove'        => [],
    'content_url_regexes'            => [],
    'content_url_regexes_remove'     => [],
    'page_props'                     => [],
    'scan_props'                     => [],
    'list_props'                     => [],
    'content_props'                  => [],
    'field_props'                    => [
      "current_timestamp"            => [],
      "current_datetime"             => [],
      "current_date"                 => [],
      "current_time"                 => [],
    ],
    "fields"                         => [
      "id"                           => ['required' => false, 'repeated' => false, 'name' => "id",             'selector' => '',                                           'prop' => '',                   'filter' => '', 'data_type' => "int", "default" => "", 'nullable' => false, "data_default" => "", "primary_key" => true, "auto_increment" => true],
      "collect_slug"                 => ['required' => true,  'repeated' => false, 'name' => "collect_slug",   'selector' => '',                                           'prop' => 'config.slug',        'filter' => '', 'data_type' => "varchar(32)", 'nullable' => false, "data_default" => "", "data_index" => true],
      // "collect_status"            => ['required' => false, 'repeated' => false, 'name' => "collect_status",  'selector' => '',              'prop' => '',                   'filter' => '',],
      // "collect_type"              => ['required' => false, 'repeated' => false, 'name' => "collect_type",   'selector' => '',              'prop' => 'page.link.url_type', 'filter' => '',],
      "url"                          => ['required' => false, 'repeated' => false, 'name' => "url",            'selector' => '',                                           'prop' => 'page.link.uri',      'filter' => '', 'data_type' => "varchar(255)", 'nullable' => false,  "data_index" => true,],
      // "id"                        => ['required' => false, 'repeated' => false, 'name' => "id",             'selector' => '',              'prop' => 'page.url',           'filter' => 'md5', "default" => "",  'data_type' => "varchar(32)", 'nullable' => false, "data_default" => "", "data_index" => true],
      // "url_md5"                   => ['required' => true,  'repeated' => false, 'name' => "url_md5",        'selector' => '',              'prop' => 'page.url',           'filter' => 'md5', 'data_type' => "varchar(32)", 'nullable' => false,  "data_index" => true,],
      "collect_at"                   => ['required' => false, 'repeated' => false, 'name' => "collect_at",     'selector' => '',                                           'prop' => 'current_datetime',  'filter' => '', 'data_type' => "timestamp",],

      "category"                     => ['required' => false, 'repeated' => false, 'name' => "category",       'selector' => '',                                           'prop' => '',                   'filter' => '',],

      "title"                        => ['required' => true,  'repeated' => false, 'name' => "title",          'selector' => "//head/title",                               'prop' => '',                   'filter' => '',],
      "description"                  => ['required' => false, 'repeated' => false, 'name' => "description",    'selector' => '//head/meta[@name="description"]/@content',  'prop' => '',                   'filter' => '',],
      "keywords"                     => ['required' => false, 'repeated' => false, 'name' => "keywords",       'selector' => '//head/meta[@name="keywords"]/@content',     'prop' => '',                   'filter' => '',],

      "slug"                         => ['required' => false, 'repeated' => false, 'name' => "slug",           'selector' => '',                                           'prop' => 'link.path',          'filter' => '', 'data_type' => "varchar(255)",],
      "ico"                          => ['required' => false, 'repeated' => false, 'name' => "ico",            'selector' => '//head/link[contains(@rel,"icon")/@href',    'prop' => '',                   'filter' => '', 'data_type' => "varchar(255)",],

      "text"                         => ['required' => false, 'repeated' => false, 'name' => "text",           'selector' => '',                                           'prop' => '',                   'filter' => '', 'data_type' => "longtext",],

      "type"                         => ['required' => false, 'repeated' => false, 'name' => "type",           'selector' => '',                                           'prop' => '',                   'filter' => '', 'data_type' => "varchar(25)",],
      "status"                       => ['required' => false, 'repeated' => false, 'name' => "status",         'selector' => '',                                           'prop' => '',                   'filter' => '', 'data_type' => "varchar(25)",],


      "parent"                       => ['required' => false, 'repeated' => false, 'name' => "parent",         'selector' => '',                                           'prop' => '',                   'filter' => '', 'data_type' => "int",],
      "count"                        => ['required' => false, 'repeated' => false, 'name' => "count",          'selector' => '',                                           'prop' => '',                   'filter' => '', 'data_type' => "int",],
      "order"                        => ['required' => false, 'repeated' => false, 'name' => "order",          'selector' => '',                                           'prop' => '',                   'filter' => '', 'data_type' => "int",],

      "created_at"                   => ['required' => false, 'repeated' => false, 'name' => "created_at",     'selector' => '',                                           'prop' => '',                   'filter' => '', 'data_type' => "varchar(10)",],
      "updated_at"                   => ['required' => false, 'repeated' => false, 'name' => "updated_at",     'selector' => '',                                           'prop' => '',                   'filter' => '', 'data_type' => "varchar(10)",],
      "release_at"                   => ['required' => false, 'repeated' => false, 'name' => "release_at",     'selector' => '',                                           'prop' => '',                   'filter' => '', 'data_type' => "varchar(10)",],
      "deleted_at"                   => ['required' => false, 'repeated' => false, 'name' => "deleted_at",     'selector' => '',                                           'prop' => '',                   'filter' => '', 'data_type' => "varchar(10)",],
    ],
    'beforeGetConfig'                => NULL,
    'afterGetConfig'                 => NULL,
    'beforeSyncTable'                => NULL,
    'afterSyncTable'                 => NULL,
    'beforeCreateSpider'             => NULL,
    'afterCreateSpider'              => NULL,
    'beforeStartSpider'              => NULL,
    "rules"                          => [],
    "methods"                        => [
      "on_start"                     => NULL,
      "on_before_download_page"      => NULL,
      "on_status_code"               => NULL,
      "is_anti_spider"               => NULL,
      "on_download_page"             => NULL,
      "on_download_attached_page"    => NULL,
      "on_fetch_url"                 => NULL,
      "on_add_url"                   => NULL,
      "on_scan_page"                 => NULL,
      "on_list_page"                 => NULL,
      "on_content_page"              => NULL,
      "on_handle_img"                => NULL,
      "on_extract_field"             => NULL,
      "on_extract_page"              => NULL,
      "on_attachment_file"           => NULL,
    ]
  ],
  "_fiels" => [],
  "_relationships" => [],
  "album"                            => [
    "name"                           => "🔴🟡🟢【图册】",
    "extends"                        => "default:_contents",
    'export_table'                   => 'ablum_contents',
  ],
  "audio"                            => [
    "name"                           => "🔴🟡🟢【音频】",
    "extends"                        => "default:_contents",
  ],
  "image"                            => [
    "name"                           => "🔴🟡🟢【图片】",
    "extends"                        => "default:_contents",
    'log_file'                       => 'logs/image_default.log',
    'export_table'                   => 'image_contents',
  ],
  "paragraoh"                        => [
    "name"                           => "🔴🟡🟢【段落】",
    "extends"                        => "default:_contents",
  ],
  "question"                         => [
    "name"                           => "🔴🟡🟢【试题】",
    "extends"                        => "default:_contents",
    'export_table'                   => 'question_contents',
    "fields"                         => [

      "option_a"                     => ['required' => false, 'repeated' => false, 'name' => "option_a",       'selector' => '',              'prop' => '',                   'filter' => '',],
      "option_b"                     => ['required' => false, 'repeated' => false, 'name' => "option_b",       'selector' => '',              'prop' => '',                   'filter' => '',],
      "option_c"                     => ['required' => false, 'repeated' => false, 'name' => "option_c",       'selector' => '',              'prop' => '',                   'filter' => '',],
      "option_d"                     => ['required' => false, 'repeated' => false, 'name' => "option_d",       'selector' => '',              'prop' => '',                   'filter' => '',],
      "option_e"                     => ['required' => false, 'repeated' => false, 'name' => "option_e",       'selector' => '',              'prop' => '',                   'filter' => '',],
      "option_f"                     => ['required' => false, 'repeated' => false, 'name' => "option_f",       'selector' => '',              'prop' => '',                   'filter' => '',],
      "option_g"                     => ['required' => false, 'repeated' => false, 'name' => "option_g",       'selector' => '',              'prop' => '',                   'filter' => '',],


      "answer"                       => ['required' => false, 'repeated' => false, 'name' => "answer",         'selector' => '',              'prop' => '',                   'filter' => '',],
      "analysis"                     => ['required' => false, 'repeated' => false, 'name' => "analysis",       'selector' => '',              'prop' => '',                   'filter' => '',],

    ],
  ],
  "queue"                         => [
    "name"                           => "🔴🟡🟢【语录】",
    "extends"                        => "default:_contents",
  ],
  "sentense"                         => [
    "name"                           => "🔴🟡🟢【句子】",
    "extends"                        => "default:_contents",
  ],
  "unit"                             => [
    "name"                           => "🔴🟡🟢【单元】",
    // "extends"                        => "default:_contents",
    'log_type'                       => 'step,info,debug,success,warn,error',
  ],
  "video"                            => [
    "name"                           => "🔴🟡🟢【视频】",
    "extends"                        => "default:_contents",
  ],
  "video-season"                     => [
    "name"                           => "🔴🟡🟢【剧集】",
    "extends"                        => "default:_contents",
  ],
  "video-collection"                 => [
    "name"                           => "🔴🟡🟢【集合】",
    "extends"                        => "default:_contents",
  ],
  "video-episode"                    => [
    "name"                           => "🔴🟡🟢【剧集】",
    "extends"                        => "default:_contents",
  ],
  "word"                             => [
    "name"                           => "🔴🟡🟢【词语】",
    "extends"                        => "default:_contents",
  ],
];

$default_word = [];
