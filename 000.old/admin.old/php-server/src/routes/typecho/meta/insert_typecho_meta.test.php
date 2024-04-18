<?php

require_once __DIR__ . "/../../index.test.php";

$response = Requests::post(API_PATH . "/typecho/meta/insert", array(
  "AUTHORIZATION" => "Bearer " . $authCode,
), array(
  "name" => $faker->name(),
  "slug" => $faker->uuid(),
  "type" => $faker->word(),
  "description" => $faker->text(),
));

print_r(json_decode($response->body, true));
