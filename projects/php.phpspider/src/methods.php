<?php

use app\controllers\db;
use app\controllers\log;
use app\controllers\selector;

/**
 * on_start($phpspider)
 * 爬虫初始化时调用, 用来指定一些爬取前的操作

 * @param $phpspider 爬虫对象
 */
$spider->on_start = function ($phpspider) use ($currentConfig) {
  // var_dump($currentConfig['slug']);
  log::step("on_start: " . $currentConfig['name']);
  // if (!is_dir(__DIR__ . '/../cache/' . $currentConfig['slug'])) mkdir(__DIR__ . '/../cache/' . $currentConfig['slug']);

  $rows = db::select($phpspider::$export_table, ["collect_slug = '" . $currentConfig['slug'] . "'", "collect_at IS NULL"]);
  // requests::set_header("Referer", "http://buluo.qq.com/p/index.html");
  // logInfo($phpspider);
  if (!str_contains($currentConfig['log_type'], 'debug'))  $phpspider->display_ui();
};
/**
 * on_status_code($status_code, $url, $content, $phpspider)
 * 判断当前网页是否被反爬虫了, 需要开发者实现
 * 
 * @param $status_code 当前网页的请求返回的HTTP状态码
 * @param $url 当前网页URL
 * @param $content 当前网页内容
 * @param $phpspider 爬虫对象
 * @return $content 返回处理后的网页内容，不处理当前页面请返回false
 */
$spider->on_status_code = function ($status_code, $url, $content, $phpspider) {
  log::step("on_status_code: " .  $url);
  // 如果状态码为429，说明对方网站设置了不让同一个客户端同时请求太多次
  if ($status_code == '429') {
    // 将url插入待爬的队列中,等待再次爬取
    $phpspider->add_url($url);
    // 当前页先不处理了
    return false;
  }
  // 不拦截的状态码这里记得要返回，否则后面内容就都空了
  return $content;
};
/**
 * is_anti_spider($url, $content, $phpspider)
 * 判断当前网页是否被反爬虫了, 需要开发者实现
 * 
 * @param $url 当前网页的url
 * @param $content 当前网页内容
 * @param $phpspider 爬虫对象
 * @return 如果被反爬虫了, 返回true, 否则返回false
 */
$spider->is_anti_spider = function ($url, $content, $phpspider) {
  log::step("is_anti_spider: " .  $url);
  // $content中包含"404页面不存在"字符串
  if (strpos($content, "404页面不存在") !== false) {
    // 如果使用了代理IP，IP切换需要时间，这里可以添加到队列等下次换了IP再抓取
    // $phpspider->add_url($url);
    return true; // 告诉框架网页被反爬虫了，不要继续处理它
  }
  // 当前页面没有被反爬虫，可以继续处理
  return false;
};
/**
 * on_download_page($page, $phpspider)
 * 在一个网页下载完成之后调用. 主要用来对下载的网页进行处理.
 * 
 * @param $page 当前下载的网页页面的对象
 * @param $phpspider 爬虫对象
 * @return 返回处理后的网页内容
 * 
 * @param $page['url'] 当前网页的URL
 * @param $page['raw'] 当前网页的内容
 * @param $page['request'] 当前网页的请求对象
 */
$spider->on_download_page = function ($page, $phpspider) use ($currentConfig) {
  log::step("on_download_page: " . $page['url']);
  // db::update($phpspider::$export_table, ['collect_at' => date('Y-m-d H:i:s')], ["collect_slug = '" . $currentConfig['slug'] . "'", "url = '" . $page['url'] . "'"]);
  // db::update($phpspider::$export_table, ['collect_at' => time()], ["collect_slug = '" . $currentConfig['slug'] . "'", "url = '" . $page['url'] . "'"]);
  // dump($phpspider);
  // dump($page);
  $url = preg_replace("/:|\//", "_", $page['url']);
  $url = preg_replace("/_+/", "_", $url);
  // if (!is_dir(__DIR__ . '/../cache/' . $currentConfig['slug'] . '/raw')) mkdir(__DIR__ . '/../cache/' . $currentConfig['slug'] . '/raw');
  // file_put_contents(__DIR__ . '/../cache/' . $currentConfig['slug'] . '/raw/' . $url . ".html", $page['raw']);
  // dump($url);
  // exit;
  // $page_html = "<div id=\"comment-pages\"><span>5</span></div>";
  // $index = strpos($page['row'], "</body>");
  // $page['raw'] = substr($page['raw'], 0, $index) . $page_html . substr($page['raw'], $index);
  // logInfo($phpspider, $currentConfig);
  if (!str_contains($currentConfig['log_type'], 'debug'))  $phpspider->display_ui();
  return $page;
};
/**
 * on_download_attached_page($content, $phpspider)
 * 在一个网页下载完成之后调用. 主要用来对下载的网页进行处理.
 * 
 * @param $content 当前下载的网页内容
 * @param $phpspider 爬虫对象
 * @return 返回处理后的网页内容
 */
$spider->on_download_attached_page = function ($content, $page, $phpspider) use ($currentConfig) {

  log::step("on_download_attached_page: " . $page['url']);
  // dump($content);
  // $content = trim($content);
  // $content = ltrim($content, "[");
  // $content = rtrim($content, "]");
  // $content = json_decode($content, true);
  // exit;
  // logInfo($phpspider, $currentConfig);
  if (!str_contains($currentConfig['log_type'], 'debug'))  $phpspider->display_ui();
  return $content;
};
/**
 * on_fetch_url($url, $phpspider)
 * 在一个网页获取到URL之后调用. 主要用来对获取到的URL进行处理.
 * 
 * @param $url 当前获取到的URL
 * @param $phpspider 爬虫对象
 * @return 返回处理后的URL，为false则此URL不入采集队列
 */
$spider->on_fetch_url = function ($url, $phpspider) use ($currentConfig) {
  log::step("on_fetch_url: " . $url);

  // $row = db::select($phpspider::$export_table, ["collect_slug = '{$currentConfig['slug']}'", "url = '$url'", "collect_at IS NOT NULL"], "limit 1");
  // $exist = db::select_exists($phpspider::$export_table, ["collect_slug = '" . $currentConfig['slug'] . "'", "url = '" . $url . "'", "collect_at IS NOT NULL"]);

  // var_dump($exist);
  // if ($exist !== false) return;
  // var_dump($exist);
  // var_dump($row);
  // db::insert($phpspider::$export_table, ["collect_slug" => $currentConfig['slug'], "url" => $url, ]);
  // exit;
  // if (strpos($url, "#filter") !== false) {
  //   return false;
  // }
  // file_put_contents(__DIR__ . '/../cache/' . $currentConfig['slug'] . '/fetch_urls', $url . PHP_EOL, FILE_APPEND | LOCK_EX);
  // if (!str_contains($currentConfig['log_type'], 'debug'))  $phpspider->display_ui();
  return $url;
};
/**
 * on_add_url($url, $phpspider)
 * 往待爬队列中添加url
 * 
 * @param $url 当前获取到的URL
 * @param $phpspider 爬虫对象
 * @return 返回处理后的URL，为false则此URL不入采集队列
 */
$spider->on_add_url = function ($url, $link, $phpspider) use ($currentConfig) {
  log::step("on_add_url: " . $link['url_type'] . ' -- ' . $url);
  if ($link['url_type'] == 'content_page') {
    $exist = db::select_exists($phpspider::$export_table, ["collect_slug = '" . $currentConfig['slug'] . "'", "url = '" . $link['uri'] . "'"]);
    if (!$exist) {
      $return = db::insert($phpspider::$export_table, ["collect_slug" => $currentConfig['slug'], "url" => $link['uri'],]);
      // $return = db::upsert($phpspider::$export_table, ["collect_slug" => $currentConfig['slug'], "url" => $url,], $phpspider::$upsert_columns);
      if ($return === false) {
        log::error("on_add_url: insert {$link['url_type']} -- " . $url);
      } else {
        log::success("on_add_url: insert {$link['url_type']} of id({$return}) -- " . $url);
      }
      unset($return);
    }
    unset($exist);
  }
  // exit;
  // if (!str_contains($currentConfig['log_type'], 'debug'))  $phpspider->display_ui();
  // return $url;
};
/**
 * on_scan_page($page, $content, $phpspider)
 * 在爬取到入口url的内容之后, 添加新的url到待爬队列之前调用. 主要用来发现新的待爬url, 并且能给新发现的url附加数据（点此查看“url附加数据”实例解析）.
 * 
 * @param $page 当前下载的网页页面的对象
 * @param $content 当前网页内容
 * @param $phpspider 当前爬虫对象
 * @return 返回false表示不需要再从此网页中发现待爬url

 * @param $page['url'] 当前网页的URL
 * @param $page['raw'] 当前网页的内容
 * @param $page['request'] 当前网页的请求对象

 * 此函数中通过调用$phpspider->add_url($url, $options)函数来添加新的url到待爬队列。
 */
$spider->on_scan_page = function ($page, $content, $phpspider) use ($currentConfig) {
  log::step("on_scan_page: " . $page['url']);
  // db::insert($phpspider::$export_table, ["collect_slug" => $currentConfig['slug'], "url" => $page['url'],]);
  // return false;
  // exit;
  // file_put_contents(__DIR__ . '/../cache/' . $currentConfig['slug'] . '/collect_scan_urls', $page['url'] . PHP_EOL, FILE_APPEND | LOCK_EX);
  if (!str_contains($currentConfig['log_type'], 'debug'))  $phpspider->display_ui();
};
/**
 * on_list_page($page, $content, $phpspider)
 * 在爬取到入口url的内容之后, 添加新的url到待爬队列之前调用. 主要用来发现新的待爬url, 并且能给新发现的url附加数据（点此查看“url附加数据”实例解析）.

 * @param  $page 当前下载的网页页面的对象
 * @param  $content 当前网页内容
 * @param  $phpspider 当前爬虫对象
 * @return 返回false表示不需要再从此网页中发现待爬url

 * @param $page['url'] 当前网页的URL
 * @param $page['raw'] 当前网页的内容
 * @param $page['request'] 当前网页的请求对象

 * 此函数中通过调用$phpspider->add_url($url, $options)函数来添加新的url到待爬队列。
 */
$spider->on_list_page = function ($page, $content, $phpspider) use ($currentConfig) {
  log::step("on_list_page: " . $page['url']);

  // $return = db::update($phpspider::$export_table, ['collect_at' => time()], ["collect_slug = '" . $currentConfig['slug'] . "'", "url = '" . $page['url'] . "'"]);
  // if ($return === false) {
  //   log::error("on_list_page: update -- " . $page['url']);
  // } else {
  //   log::success("on_list_page: update id({$return}) -- " . $page['url']);
  // }
  // unset($return);
  // log::success("on_list_page: " . $page['url']);
  // log::error("on_list_page: " . $page['url']);

  // db::insert($phpspider::$export_table, ["collect_slug" => $currentConfig['slug'], "url" => $page['url'],]);
  // return false;
  // file_put_contents(__DIR__ . '/../cache/' . $currentConfig['slug'] . '/collect_list_urls', $page['url'] . PHP_EOL, FILE_APPEND | LOCK_EX);
  if (!str_contains($currentConfig['log_type'], 'debug'))  $phpspider->display_ui();
};
/**
 * on_content_page($page, $content, $phpspider)
 * 在爬取到入口url的内容之后, 添加新的url到待爬队列之前调用. 主要用来发现新的待爬url, 并且能给新发现的url附加数据（点此查看“url附加数据”实例解析）.

 * @param $page 当前下载的网页页面的对象
 * @param $content 当前网页内容
 * @param $phpspider 当前爬虫对象
 * @return 返回false表示不需要再从此网页中发现待爬url

 * @param $page['url'] 当前网页的URL
 * @param $page['raw'] 当前网页的内容
 * @param $page['request'] 当前网页的请求对象

 * 此函数中通过调用$phpspider->add_url($url, $options)函数来添加新的url到待爬队列。
 */
$spider->on_content_page = function ($page, $content, $phpspider) use ($currentConfig) {
  log::step("on_content_page: " . $page['url']);
  // $return = db::update($phpspider::$export_table, ['collect_at' => time()], ["collect_slug = '" . $currentConfig['slug'] . "'", "url = '" . $page['url'] . "'"]);

  $phpspider->set_fields_prop('current_timestamp', time());
  $phpspider->set_fields_prop('current_datetime', date('Y-m-d H:i:s'));
  $phpspider->set_fields_prop('current_date', date('Y-m-d'));
  $phpspider->set_fields_prop('current_time', date('H:i:s'));
  $phpspider->set_fields_prop('a1.a2.a3.a4', time());
  // var_dump($phpspider::$fields_prop);
  // exit;
  // if ($return === false) {
  //   log::error("on_content_page: update -- " . $page['url']);
  // } else {
  //   log::success("on_content_page: update affected_rows({$return}) -- " . $page['url']);
  // }
  // unset($return);
  // db::insert($phpspider::$export_table, ["collect_slug" => $currentConfig['slug'], "url" => $page['url'],]);
  // return false;
  // file_put_contents(__DIR__ . '/../cache/' . $currentConfig['slug'] . '/collect_content_urls', $page['url'] . PHP_EOL, FILE_APPEND | LOCK_EX);
  if (!str_contains($currentConfig['log_type'], 'debug'))  $phpspider->display_ui();
};
/**
 * on_handle_img($fieldname, $img)
 * 在抽取到field内容之后调用, 对其中包含的img标签进行回调处理

 * @param $fieldname 当前field的name. 注意: 子field的name会带着父field的name, 通过.连接.
 * @param $img 整个img标签的内容
 * @return 返回处理后的img标签的内容

 * 很多网站对图片作了延迟加载, 这时候就需要在这个函数里面来处理
 */
$spider->on_handle_img = function ($fieldname, $img) {
  log::step("on_handle_img: " .  $img);
  // $regex = '/src="(https?:\/\/.*?)"/i';
  // preg_match($regex, $img, $rs);
  // if (!$rs) {
  //   return $img;
  // }
  // $url = $rs[1];
  // if ($url == "http://x.autoimg.cn/club/lazyload.png") {
  //   $regex2 = '/src9="(https?:\/\/.*?)"/i';
  //   preg_match($regex, $img, $rs);
  //   // 替换成真是图片url
  //   if (!$rs) {
  //     $new_url = $rs[1];
  //     $img = str_replace($url, $new_url);
  //   }
  // }
  if ($src = selector::select($img, "//img/@src")) {
    return $src;
  }
  // var_dump($src);
  // exit;
  return $img;
};
/**
 * on_extract_field($fieldname, $data, $page)
 * 当一个field的内容被抽取到后进行的回调, 在此回调中可以对网页中抽取的内容作进一步处理

 * @param $fieldname 当前field的name. 注意: 子field的name会带着父field的name, 通过.连接.
 * @param $data 当前field抽取到的数据. 如果该field是repeated, data为数组类型, 否则是String
 * @param $page 当前下载的网页页面的对象
 * @return 返回处理后的数据, 注意数据类型需要跟传进来的$data类型匹配

 * @param $page['url'] 当前网页的URL
 * @param $page['raw'] 当前网页的内容
 * @param $page['request'] 当前网页的请求对象
 */
$spider->on_extract_field = function ($fieldname, $data, $page) {
  // log::warn("on_extract_field: " . $page['url'] . ', ' . $fieldname);
  // if ($fieldname == 'gender') {
  //   // data中包含"icon-profile-male"，说明当前知乎用户是男性
  //   if (strpos($data, "icon-profile-male") !== false) {
  //     return "男";
  //   }
  //   // data中包含"icon-profile-female"，说明当前知乎用户是女性
  //   elseif (strpos($data, "icon-profile-female") !== false) {
  //     return "女";
  //   } else {
  //     return "未知";
  //   }
  // }
  // if (empty($data)) return NULL;
  return $data;
};
/**
 * on_extract_page($page, $data)
 * 在一个网页的所有field抽取完成之后, 可能需要对field进一步处理, 以发布到自己的网站

 * @param $page 当前下载的网页页面的对象
 * @param $data 当前网页抽取出来的所有field的数据
 * @return 返回处理后的数据, 注意数据类型需要跟传进来的$data类型匹配

 * @param $page['url'] 当前网页的URL
 * @param $page['raw'] 当前网页的内容
 * @param $page['request'] 当前网页的请求对象
 */
$spider->on_extract_page = function ($page, $data) use ($currentConfig) {
  log::step("on_extract_page: " . $page['url']);
  // var_dump($page);
  global $argv;
  // $title = "[{$data['time']}]" . $data['title'];
  // $data['title'] = $title;

  // $data['_url'] = $page['url'];
  // $data['id'] = md5($page['url']);
  if ($argv[1] == 'test') {
    print_r($page['url']) . PHP_EOL;
    print_r($data) . PHP_EOL;
    exit;
  }


  if ($currentConfig['export']['type'] == 'csv') {
    foreach ($data as $key => $value) {
      $data[$key] = json_encode($value, JSON_UNESCAPED_UNICODE);
    }
  }
  // if ($currentConfig['max_fields'] !== 0) {
  //   // var_dump($data);
  // }
  return $data;
  // 返回false不处理，当前页面的字段不入数据库直接过滤
  // 比如采集电影网站，标题匹配到“预告片”这三个字就过滤
  //if (strpos($data['title'], "预告片") !== false)
  //{
  //    return false;
  //}
};
