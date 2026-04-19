<?php
return [
  "13384" => [
    'name' => '13384美女图',
    'tasknum' => 1,
    //'multiserver' => true,
    'log_show' => true,
    //'save_running_state' => false,
    'domains' => array(
      'www.13384.com'
    ),
    'scan_urls' => array(
      "http://www.13384.com/qingchunmeinv/",
      "http://www.13384.com/xingganmeinv/",
      "http://www.13384.com/mingxingmeinv/",
      "http://www.13384.com/siwameitui/",
      "http://www.13384.com/meinvmote/",
      "http://www.13384.com/weimeixiezhen/",
    ),
    'list_url_regexes' => array(
      "http://www.13384.com/qingchunmeinv/index_\d+.html",
      "http://www.13384.com/xingganmeinv/index_\d+.html",
      "http://www.13384.com/mingxingmeinv/index_\d+.html",
      "http://www.13384.com/siwameitui/index_\d+.html",
      "http://www.13384.com/meinvmote/index_\d+.html",
      "http://www.13384.com/weimeixiezhen/index_\d+.html",
    ),
    'content_url_regexes' => array(
      "http://www.13384.com/qingchunmeinv/\d+.html",
      "http://www.13384.com/xingganmeinv/\d+.html",
      "http://www.13384.com/mingxingmeinv/\d+.html",
      "http://www.13384.com/siwameitui/\d+.html",
      "http://www.13384.com/meinvmote/\d+.html",
      "http://www.13384.com/weimeixiezhen/\d+.html",
    ),
    //'export' => array(
    //'type' => 'db', 
    //'table' => 'meinv_content',
    //),
    'db_config' => array(
      'host'  => '127.0.0.1',
      'port'  => 3306,
      'user'  => 'root',
      'pass'  => 'root',
      'name'  => 'qiushibaike',
    ),
    'fields' => array(
      // 标题
      array(
        'name' => "name",
        'selector' => "//div[@id='Article']//h1",
        'required' => true,
      ),
      // 分类
      array(
        'name' => "category",
        'selector' => "//div[contains(@class,'crumbs')]//span//a",
        'required' => true,
      ),
      // 发布时间
      array(
        'name' => "addtime",
        'selector' => "//p[contains(@class,'sub-info')]//span",
        'required' => true,
      ),
      // API URL
      array(
        'name' => "url",
        'selector' => "//p[contains(@class,'sub-info')]//span",
        'required' => true,
      ),
      // 图片
      array(
        'name' => "image",
        'selector' => "//*[@id='big-pic']//a//img",
        'required' => true,
      ),
      // 内容
      array(
        'name' => "content",
        'selector' => "//div[@id='pages']//a//@href",
        'repeated' => true,
        'required' => true,
        'children' => array(
          array(
            // 抽取出其他分页的url待用
            'name' => 'content_page_url',
            'selector' => "//text()"
          ),
          array(
            // 抽取其他分页的内容
            'name' => 'page_content',
            // 发送 attached_url 请求获取其他的分页数据
            // attached_url 使用了上面抓取的 content_page_url
            'source_type' => 'attached_url',
            'attached_url' => 'content_page_url',
            'selector' => "//*[@id='big-pic']//a//img"
          ),
        ),
      ),
    ),
  ]
];
