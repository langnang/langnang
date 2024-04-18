<?php

require_once __DIR__ . "/../../index.test.php";

$response = Requests::post(API_PATH . "/typecho/meta/list", array(
  "AUTHORIZATION" => "Bearer " . $authCode,
), array());

print_r(json_decode($response->body, true));
