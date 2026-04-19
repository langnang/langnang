<?php

return [
  "meitu131" => [
    'slug'                           => 'image_meitu131',
    'name'                           => '🟢【图片】美图131',
    "extends"                        => "default:image",
    'log_file'                       => 'logs/image_meitu131.log',
    // 'log_type'                       => 'step,info,debug,success,warn,error',
    'queue_prefix'                   => 'phpspider:image_contents:meitu131',
    'domains'                        => [
      "meitu131.com",
      "www.meitu131.com"
    ],
    'scan_urls'                      => [
      "https://www.meitu131.com/",
    ],
    'list_url_regexes'               => [
      "https://www.meitu131.com/[a-z]+/",
      "https://www.meitu131.com/[a-z]+/[a-z]+/",
    ],
    'content_url_regexes'            => [
      "https://www.meitu131.com/[a-z]+/[a-z]+/[0-9]+/\S.+"
    ],

    "fields" => [
      "title"                        => ['required' => true,  'repeated' => false, 'name' => "title",          'selector' => '//*[@id="main-wrapper"]/div[1]/h1',                               'prop' => '',                   'filter' => '',],
      "category"                     => ['required' => false, 'repeated' => true,  'name' => "category",       'selector' => '//*[@id="main-wrapper"]/div[1]/div/a[position()>1]', 'prop' => '',                   'filter' => '',],
      "ico"                          => ['required' => false, 'repeated' => false, 'name' => "ico",            'selector' => '//*[@id="main-wrapper"]/div[2]//img/..',           'prop' => '',                   'filter' => '', 'data_type' => "varchar(255)",],
    ],
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
];
