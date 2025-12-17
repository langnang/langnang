<?php

require_once __DIR__ . '/../helpers/request.php';

$config = parse_ini_file(__DIR__ . '/../.env', true);
// print_r($config);
$url = 'http://101.126.135.139:7500/api/proxy/tcp';
// $res = request(['url' => 'http://101.126.135.139:7500/api/proxy/tcp']);
$res = get($url, ['headers' => [
  "Authorization: Basic " . $config['FrpS']['TOKEN'], // 替换为实际的 Bearer Token
  "Content-Type: application/json"
]]);
$res = json_decode($res, JSON_UNESCAPED_UNICODE);

// var_dump($res);

foreach ($res['proxies'] as $proxy) {

  echo $proxy['name'] . PHP_EOL;
  echo $proxy['conf']['remotePort'] . PHP_EOL;
  // curlPing('http://101.126.135.139:' . $proxy['conf']['remotePort']);
  socketPing('101.126.135.139', $proxy['conf']['remotePort']);
}
