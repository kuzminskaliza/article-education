<?php

use backend\BackendApp;

require '../vendor/autoload.php';

$config = require 'config.php';

if (!file_exists('config-local.php')) {
    echo 'No config local file.';
    exit();
}

$configLocal = require 'config-local.php'; // сетимо локальні параметри
$config = array_merge($config, $configLocal);

$application = new BackendApp($config);
$application->setErrorHandler();
$application->run();
