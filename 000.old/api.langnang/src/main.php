<?php

/**
 * @license Apache 2.0
 */
/**
 * @OA\SecurityScheme(
 *   securityScheme="X-Access-Token",
 *   type="apiKey",
 *   in="header",
 *   name="X-Access-Token"
 * )
 */
/**
 * @OA\Info(
 *     description="api for langnang",
 *     version="1.0.0",
 *     title="APIs for langnang",
 *     @OA\Contact(
 *         email="langnang.chen@outlook.com"
 *     ),
 * )
 */

$files = load_src_files(__DIR__);
foreach ($files as $file) {
  include_once $file;
}
function load_src_files($path)
{
  $files = array();
  if (false != ($handle = opendir($path))) {
    while (false !== ($file = readdir($handle))) {
      //去掉"“.”、“..”以及带“.xxx”后缀的文件
      if ($file != "." && $file != "..") {
        if (is_dir($path . "/" . $file)) {
          $files = array_merge($files, load_src_files($path . "/" . $file));
        } else
        if ($file != "main.php" && strpos($file, ".php")) {
          array_push($files, $path . "/" . $file);
        }
      }
    }
    //关闭句柄
    closedir($handle);
  }
  return $files;
}

/**
 *
 */

/**
 *     name="visit",
 *     description="访问",
 *     name="link",
 *     description="导航链接",
 *     name="new",
 *     description="新闻",
 *     name="ftp",
 *     description="FTP",
 *     name="deploy",
 *     description="部署",
 *     name="service",
 *     description="服务",
 *     name="data",
 *     description="数据",
 *     name="music",
 *     description="音频",
 *     name="video",
 *     description="视频",
 *     name="weather",
 *     description="天气",
 *     name="vehicle",
 *     description="交通工具",
 *     name="url-shorteners",
 *     description="网址缩短",
 *     name="shopping",
 *     description="购物",
 *     name="public-api",
 *     description="公共接口",
 *     name="cyclopedia",
 *     description="百科词典",
 *     name="deploy",
 *     description="部署站",
 *     template 模板
 *     typecho
 *     worktile
 *  Animals
Anime
Anti-Malware
Art & Design
Books
Business
Calendar
Cloud Storage & File Sharing
Continuous Integration
Cryptocurrency
Currency Exchange
Data Validation
Development
Dictionaries
Documents & Productivity
Environment
Events
Finance
Food & Drink
Games & Comics
Geocoding
Government
Health
Jobs
Machine Learning
Music
News
Open Data
Open Source Projects
Patent
Personality
Phone
Photography
Science & Math
Security
Shopping
Social
Sports & Fitness
Test Data
Text Analysis
Tracking
Transportation
URL Shorteners
Vehicle
Video
Weather
Animals
 */
/**
 * One 系列 One for All 一即全
 * - OneSE
 * - OneBookmark
 * Simple 系列
 * No Coding 系列
 * All 系列 All for One 全即一
 * -- Free / Custom
 *
 *     name="Novel",
 *     description="小说",
 *     name="rp",
 *     description="人口普查",
 *     name="sentence",
 *     description="一句话，鸡汤，毒鸡汤，语录，名言警句，成语，歇后语，对联",
 *     name="weather",
 *     description="天气",
 *     name="simple",
 *     description="简化系列",
 *     name="one",
 *     description="All for One，全即一",
 *     name="none",
 *     description="无",
 *     name="all",
 *     description="One for All，一即全",
 * Seasonal 应季的水果、蔬菜、海鲜、食品
 * 
 */
