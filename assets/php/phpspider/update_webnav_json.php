<?php

$path = __DIR__ . '/../../data/webnav.json';

$data = json_decode(file_get_contents($path), true);
// dump($data);
$update_contents = [];
if (file_exists(__DIR__ . '/webnav')) {
  $update_contents = explode("\r\n", file_get_contents(__DIR__ . '/webnav'));
}
$contents = $data['contents'] ?? [];
// dump($contents);

use phpspider\core\phpspider;
use phpspider\core\requests;
use phpspider\core\selector;


foreach ($update_contents as $slug) {
  if (!empty($slug) && !array_key_exists($slug, $contents)) {
    $contents[$slug] = [];
  }
}

if (sizeof($update_contents) > 0) {
  unlink(__DIR__ . '/webnav');
}


foreach ($contents as $slug => $content) {
  if (!empty($content))
    continue;
  // dump([$slug, $content]);
  // html
  $html = requests::get($slug);
  // slug
  $contents[$slug]['slug'] = $slug;
  // title
  $selector = "//head//title";
  $contents[$slug]['title'] = trim(selector::select($html, $selector));
  // description
  $selector = "//head//meta[@name='description']/@content";
  $contents[$slug]['description'] = trim(selector::select($html, $selector));
  // keywords
  $selector = "//head//meta[@name='keywords']/@content";
  $contents[$slug]['_keywords'] = trim(selector::select($html, $selector));
  if (empty($contents[$slug]['_keywords'])) $contents[$slug]['keywords'] = [];
  else $contents[$slug]['keywords'] = implode(",", $contents[$slug]['_keywords']);
  $contents[$slug]['keywords'] = array_map(function ($value) {
    return trim($value);
  }, $contents[$slug]['keywords']);
  // icon
  $selector = "//head//link[contains(@rel,'icon')]/@href";
  $contents[$slug]['icon'] = selector::select($html, $selector);
  if (empty($contents[$slug]['icon']) || $contents[$slug]['icon'] == 'favicon.ico')
    $contents[$slug]['icon'] = '/favicon.ico';

  $data['contents'] = $contents;
  file_put_contents($path, json_encode($data, JSON_UNESCAPED_UNICODE));
}
foreach ($contents as $slug => $content) {
  // $contents[$slug]['_keywords'] =  $contents[$slug]['keywords'];
  // $contents[$slug]['keywords'] = explode(",", $contents[$slug]['_keywords']);
  if (empty($contents[$slug]['_keywords'])) $contents[$slug]['keywords'] = [];
  $contents[$slug]['keywords'] = array_map(function ($value) {
    return trim($value);
  }, $contents[$slug]['keywords']);
}
$data['contents'] = $contents;
file_put_contents($path, json_encode($data, JSON_UNESCAPED_UNICODE));
// $data['contents'] = $contents;
// file_put_contents($path, json_encode($data, JSON_UNESCAPED_UNICODE));
// dump($data);
