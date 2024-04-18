<?php

require_once __DIR__ . "/../../index.test.php";

$response = Requests::post(API_PATH . "/typecho/meta/delete", array(
  "AUTHORIZATION" => "Bearer " . $authCode,
), array(
  "mids" => [$faker->randomNumber(3, false)],
));

print_r(json_decode($response->body, true));
