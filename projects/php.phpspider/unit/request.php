<?php

// 引入PATH_DATA
// require_once __DIR__ . '/../app/helpers/constants.php';

// // require_once __DIR__ . '/../app/controllers/util.php';
// // require_once __DIR__ . '/../app/controllers/log.php';
// // require_once __DIR__ . '/../app/controllers/db.php';
require_once __DIR__ . '/../app/controllers/requests.php';
require_once __DIR__ . '/../app/controllers/selector.php';
// // require_once __DIR__ . '/../app/controllers/phpspider.php';
// // require_once __DIR__ . '/../app/controllers/queue.php';

// require_once __DIR__ . '/../src/helpers.php';

use app\controllers\requests;
use app\controllers\selector;

var_dump($_GET);
if (!isset($_GET['s'])) exit;
$slug = $_GET['s'];

var_dump($slug);

$url = 'https://www.dramaface.com/model/kanamorisawa';

$html = requests::get($url);
// ul.fanhao-list
$selector = "//li[contains(@class,'fh-item')]";
// 提取结果
$result = selector::select($html, $selector);
// print_r($result);

foreach ($result as $item) {
  $code_selector = "";
  $runtime_selector = "";
  $release_selector = "";
  $company_selector = "";
  var_dump($item);
}
