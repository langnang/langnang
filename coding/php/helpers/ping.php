<?php
function exec_ping($host, $count = 4)
{
  $output = array();
  exec("ping -n $count $host", $output, $status);
  if ($status === 0) {
    foreach ($output as $line) {
      echo $line, "\n";
    }
    return true;
  } else {
    echo "Ping failed.";
    return false;
  }
}

function curl_ping($url)
{
  $startTime = microtime(true);
  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_TIMEOUT, 10);
  $output = curl_exec($ch);
  $endTime = microtime(true);
  if (curl_errno($ch)) {
    echo "cURL error: " . curl_error($ch);
  } else {
    $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if ($statusCode === 200) {
      $duration = $endTime - $startTime;
      echo "Response time: " . $duration . " seconds";
    } else {
      echo "Server response error with status code: " . $statusCode;
    }
  }
  curl_close($ch);
}

function socket_ping($host, $port = 80, $timeout = 10)
{
  $startTime = microtime(true);
  $fsock = fsockopen($host, $port, $errno, $errstr, $timeout);
  if (!$fsock) {
    echo "Failed to connect: $errstr ($errno)\n";
  } else {
    $endTime = microtime(true);
    $duration = $endTime - $startTime;
    echo "Connected. Response time: " . $duration . " seconds";
    fclose($fsock);
  }
}
