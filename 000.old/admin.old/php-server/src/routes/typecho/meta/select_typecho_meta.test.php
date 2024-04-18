<?php

require_once __DIR__ . "/../../index.test.php";

$response = Requests::post(API_PATH . "/typecho/meta/info", array(
  "AUTHORIZATION" => "Bearer " . $authCode,
), json_encode(array(
  "mids" => [(int)$faker->randomNumber(3, false)],
)));

print_r(json_decode($response->body, true));
