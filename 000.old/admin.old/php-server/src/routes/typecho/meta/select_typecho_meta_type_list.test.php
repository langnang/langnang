<?php

require_once __DIR__ . "/../../index.test.php";

$response = Requests::post(API_PATH . "/typecho/meta/type", array(
  "AUTHORIZATION" => "Bearer " . $authCode,
), json_encode(array()));

print_r(json_decode($response->body, true));
