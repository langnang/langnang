<?php

if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require_once __DIR__ . '/vendor/autoload.php';
}
if (file_exists(__DIR__ . '/../../vendor/autoload.php')) {
    require_once __DIR__ . '/../../vendor/autoload.php';
}

// print ('Missing Require File');
// exit;

/** 载入配置支持 */
if (!file_exists(__DIR__ . '/.env')) {
    file_exists('./install.php') ? header('Location: install.php') : print ('Missing Config File');
    exit;
}


$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

dump($dotenv);
dump($_ENV);
dump($_SERVER);

dump(get_declared_classes());