<?php

use Langnang\Component\Crawler\CrawlerController;

function insert_crawler_post($data)
{
  return CrawlerController::insert($data);
}
