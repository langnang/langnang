<?php

require_once __DIR__ . "/../../index.test.php";

$response = Requests::post(API_PATH . "/typecho/meta/update", array(
  "AUTHORIZATION" => "Bearer " . $authCode,
), json_encode(array(
  "mid" => (int)$faker->randomNumber(3, false),
  "name" => $faker->name(),
  "slug" => $faker->uuid(),
  "type" => $faker->word(),
  "description" => $faker->text(),
)));

print_r(json_decode($response->body, true));
