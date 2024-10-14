<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use backend\BackendApp;

require '../vendor/autoload.php';

$config = require 'config.php';
// Router дивиться куди треба піти

(new BackendApp($config))->run();