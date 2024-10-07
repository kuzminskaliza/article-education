<?php

use backend\BackendApp;

require '../vendor/autoload.php';

$config = require 'config.php';
// Router дивиться куди треба піти

(new BackendApp($config))->run();