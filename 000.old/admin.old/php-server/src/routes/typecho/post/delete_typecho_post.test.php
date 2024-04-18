<?php

require_once __DIR__ . "/../../index.test.php";

$response = Requests::post(API_PATH . "/typecho/post/delete", array(
  "AUTHORIZATION" => "Bearer " . $authCode,
), array(
  "cids" => [$faker->randomNumber(3, false)],
));
// print_r($response->body);
print_r(json_decode($response->body, true));
