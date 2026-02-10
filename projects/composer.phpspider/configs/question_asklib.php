<?php return [
  'slug' => 'question_asklib',
  'name' => '【试题】问答库',
  'title' => "试题：问答库",
  'log_show' => true,
  'log_file' => 'logs/question_asklib.log',
  'log_type' => 'error',
  'max_depth' => 1,
  'max_fields' => 2,
  'export' => [
    'type' => 'csv',
    'file' => './data/question_asklib.csv', // data目录下
  ],
  'domains' => [
    'asklib.com',
    'www.asklib.com',
  ],
  'scan_urls' => [
    // "https://www.asklib.com",
    "https://www.asklib.com/view/1e05e29c.html",
  ],
  'list_url_regexes' => [
    "https://www.asklib.com/.+",
  ],
  'content_url_regexes' => [
    "https://www.asklib.com/view/\S+.html",
  ],
  "fields" => [
    [
      'name' => "category",
      'selector' => "//*[contains(@class,'seotops')]/text()",
      'filter' => '',
    ],
    [
      'name' => "title",
      'selector' => "//*[contains(@class,'essaytitle')]//h1",
      'filter' => '',
      'required' => true
    ],
    [
      'name' => "content",
      'selector' => "//*[contains(@class,'essaytitle')]//p[last()]",
      'filter' => '',
      'required' => true
    ],
    [
      'name' => "type",
      'selector' => "//*[contains(@class,'essaytitle')]//h1",
      'filter' => '',
    ],
    [
      'name' => "answer",
      'selector' => "//*[contains(@class,'listbg')]",
      'filter' => '',
    ],
    [
      'name' => "analysis",
      'selector' => "//*[contains(@id,'commentDiv')]",
      'filter' => '',
    ],
  ],
  "rules" => [],
  "methods" => [
    "on_start" => NULL,
    "on_before_download_page" => NULL,
    "on_status_code" => NULL,
    "is_anti_spider" =>  NULL,
    "on_download_page" =>  NULL,
    "on_download_attached_page" =>  NULL,
    "on_fetch_url" =>  NULL,
    "on_scan_page" =>  NULL,
    "on_list_page" =>  NULL,
    "on_content_page" =>  NULL,
    "on_handle_img" =>  NULL,
    "on_extract_field" =>  NULL,
    "on_extract_page" =>  NULL,
    "on_attachment_file" =>  NULL,
  ]
];
