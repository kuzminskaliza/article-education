<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use backend\BackendApp;

require '../vendor/autoload.php';

$config = require 'config.php';

if (!file_exists('config-local.php')) {
    echo 'No config local file.';
    exit();
}

$configLocal = require 'config-local.php'; // сетимо локальні параметри
$config = array_merge($config, $configLocal);


// Router дивиться куди треба піти
(new BackendApp($config))->run();
