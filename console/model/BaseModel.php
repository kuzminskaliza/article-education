<?php

namespace console\model;

use common\model\BaseModel as BaseModelCommon;
use console\ConsoleApp;

abstract class BaseModel extends BaseModelCommon
{
    public function __construct()
    {
        $this->pdo = ConsoleApp::$pdo;
    }
}
